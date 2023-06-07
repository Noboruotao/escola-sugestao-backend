<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
    ];

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i',
    ];

    public function areas()
    {
        return $this->belongsToMany(AreasDeConhecimento::class, 'parametros_para_sugerir_curso')->withPivot('valor');
    }


    public function getAreas()
    {
        return $this->areas()->pluck('nome');
    }


    public static function sugerirCursos($aluno)
    {
        $areas_do_aluno = $aluno->areas;
        $cusos_sugerido = DB::table('curso_sugerido')->where('aluno_id', $aluno->id)->get();

        $datas = [];

        foreach (Curso::whereNotIn('id', $cusos_sugerido->pluck('curso_id')->toArray())->get() as $curso) {
            foreach ($curso->areas as $area) {
                $parametro_count = $curso->areas->count();

                $area_do_aluno = $areas_do_aluno->firstWhere('id', $area->id);
                if ($area_do_aluno) {
                    $valor_total_do_aluno = $area_do_aluno->pivot->valor_calculado_por_notas
                        + $area_do_aluno->pivot->valor_calculado_pelo_emprestimo_de_acervo + $area_do_aluno->pivot->valor_calculado_por_atividade_extracurricular
                        + $area_do_aluno->pivot->valor_respondido_pelo_aluno;

                    if ($valor_total_do_aluno >= $area->pivot->valor) {
                        $parametro_count--;
                    }
                }

                if ($parametro_count == 0) {
                    $datas[] = [
                        'aluno_id' => $aluno->id,
                        'curso_id' => $curso->id
                    ];
                }
            }
        }

        $data = collect($datas)->map(function ($data) {
            return $data;
        });

        foreach (array_chunk($data->toArray(), 200) as $data_parts) {
            DB::table('curso_sugerido')->insert($data_parts);
        }
    }
}
