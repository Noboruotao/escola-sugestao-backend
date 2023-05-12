<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


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


    public function updateAlunoAreas($aluno, $atividade_extracurricular)
    {
        $areas_do_aluno = $aluno->areas;
        if($aluno->id==44)
            {
                echo $atividade_extracurricular->nome. PHP_EOL;
                echo $atividade_extracurricular->areas->pluck('id'). PHP_EOL;
            }

        foreach($atividade_extracurricular->areas as $area)
        {
            
            if ($areas_do_aluno->contains('id', $area->id)) {
                $area_do_aluno = $areas_do_aluno->firstWhere('id', $area->id);
                $area_do_aluno->pivot->valor_calculado_por_atividade_extracurricular += 1;
                $area_do_aluno->pivot->update(['valor_calculado_por_atividade_extracurricular' => $area_do_aluno->pivot->valor_calculado_por_atividade_extracurricular]);
            }else{

                $data = collect([[
                    'aluno_id'=> $aluno->id,
                    'areas_de_conhecimento_id'=> $area->id,
                    'valor_calculado_por_atividade_extracurricular'=> 1.0
                ]])->map(function($data){
                    return $data;
                });
        
                foreach(array_chunk($data->toArray(), 200) as $data_parts)
                {
                    \Illuminate\Support\Facades\DB::table('aluno_areas_de_conhecimento')->insert($data_parts);    
                }
            }
        }
    }
}
