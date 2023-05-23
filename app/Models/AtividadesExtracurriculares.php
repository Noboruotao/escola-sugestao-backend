<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class AtividadesExtracurriculares extends Model
{
    use HasFactory;
    protected $table = 'atividade_extracurriculares';
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'tipo_id',
        'ativo'
    ];

    protected $guarded = [
        'id'
    ];


    public function areas()
    {
        return $this->belongsToMany(AreasDeConhecimento::class, 'areas_de_conhecimento_atividades_extracurricular');
    } 


    public function parametroAreas()
    {
        return $this->belongsToMany(AreasDeConhecimento::class, 'parametro_para_sugerir_atividade_extracurricular')->withPivot('valor');
    } 
    
    
    public function alunos()
    {
        return $this->belongsToMany(alunos::class)->withPivot('ativo');
    }


    public function updateAreaValue($areas_do_aluno, $areaId)
    {
        $area_do_aluno = $areas_do_aluno->firstWhere('id', $areaId);
        $area_do_aluno->pivot->increment('valor_calculado_por_atividade_extracurricular', 1.0);
    }

    public function insertAreaValue($alunoId, $areaId)
    {
        DB::table('aluno_areas_de_conhecimento')->insert([
            'aluno_id' => $alunoId,
            'areas_de_conhecimento_id' => $areaId,
            'valor_calculado_por_atividade_extracurricular' => 1.0
        ]);
    }


    public function updateAlunoAreas($aluno, $atividade_extracurricular)
    {
        $atividade = new AtividadesExtracurriculares();
        foreach ($atividade_extracurricular->areas as $area) {
            $areas_do_aluno = $aluno->areas;
            if ($areas_do_aluno->contains('id', $area->id)) {
                $atividade->updateAreaValue($areas_do_aluno, $area->id);
            } else {
                $existingRelation = DB::table('aluno_areas_de_conhecimento')
                    ->where('aluno_id', $aluno->id)
                    ->where('areas_de_conhecimento_id', $area->id)
                    ->exists();
                if (!$existingRelation) 
                {
                    $atividade->insertAreaValue($aluno->id, $area->id);
                }
            }
        }
    }



    public function sugerirAtividadeExtracurricular($aluno)
    {
        $areas_do_aluno = $aluno->areas;
        $atividades_sugerido = DB::table('atividade_extracurricular_sugeridas')->where('aluno_id', $aluno->id)->get();

        $datas = [];

        foreach(AtividadesExtracurriculares::whereNotIn('id', $atividades_sugerido->pluck('atividade_extracurricular_id')->toArray())->get() as $ativExtra)
        {
            foreach($ativExtra->parametroAreas as $area)
            {
                $parametro_count = $ativExtra->parametroAreas->count();

                $area_do_aluno = $areas_do_aluno->firstWhere('id', $area->id);
                if( $area_do_aluno )
                {
                    $valor_total_do_aluno = $area_do_aluno->pivot->valor_calculado_por_notas
                    +$area_do_aluno->pivot->valor_calculado_pelo_atividade_de_atividade_extracurricular+$area_do_aluno->pivot->valor_calculado_por_atividade_extracurricular
                    +$area_do_aluno->pivot->valor_respondido_pelo_aluno;
                    
                    if($valor_total_do_aluno >= $area->pivot->valor)
                    {
                        $parametro_count--;
                    }
                }

                if($parametro_count == 0)
                {
                    $datas[] = [
                        'aluno_id'=> $aluno->id,
                        'atividade_extracurricular_id'=> $ativExtra->id,
                    ];
                }
            }
            

            
        }

        $data = collect($datas)->map(function($data){
            return $data;
        });

        foreach(array_chunk($data->toArray(), 200) as $data_parts)
        {
            DB::table('atividade_extracurricular_sugeridas')->insert($data_parts);    
        }
    }
}
