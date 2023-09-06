<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isEmpty;

class Aluno extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'periodo_id',
        'situacao_id'
    ];


    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id', 'id');
    }


    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }


    public function situacao()
    {
        return $this->belongsTo(AlunoSituacao::class);
    }


    public function bolsas()
    {
        return $this->belongsToMany(Bolsa::class, 'aluno_bolsa', 'aluno_id', 'bolsa_id');
    }


    public function bolsaValor()
    {
        return $this->bolsas()->sum('valor');
    }


    public function responsavel()
    {
        return $this->belongsToMany(Pessoa::class, 'responsavel', 'aluno_id', 'responsavel_id');
    }


    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }


    public function cursosSugeridos()
    {
        return $this->morphedByMany(Curso::class, 'sugerido', 'sugeridos', 'aluno_id', 'sugerido_id');
    }


    public function ativExtraSugeridos()
    {
        return $this->morphedByMany(AtividadeExtra::class, 'sugerido', 'sugeridos', 'aluno_id', 'sugerido_id');
    }


    public function ativExtra()
    {
        return $this->belongsToMany(AtividadeExtra::class, 'aluno_ativExtra', 'aluno_id', 'ativExtra_id');
    }


    public function classes()
    {
        return $this->belongsToMany(Classe::class)->withPivot(['presenca', 'faltas']);;
    }


    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'aluno_Disciplina')
            ->using(AlunoDisciplina::class)
            ->withPivot('situacao_id', 'nota_final');
    }


    public function areas()
    {
        return $this->belongsToMany(AreaConhecimento::class, 'aluno_areas_de_conhecimento', 'aluno_id', 'area_codigo', 'id', 'codigo', 'areas')
            ->using(AlunoAreasDeConhecimento::class)
            ->withPivot('valor_notas', 'valor_acervos', 'valor_atividades', 'valor_respondido');
    }


    public function AttributeAlunoAreaByNota($disciplina_id)
    {
        $disciplina = Disciplina::find($disciplina_id);

        foreach ($disciplina->areas as $area) {
            $disciplinas = $this->disciplinas()
                ->wherePivotNotNull('nota_final')
                ->where('nota_final', '<>', null)
                ->whereHas('areas', function ($query) use ($area) {
                    $query->where('area_codigo', $area->codigo);
                })
                ->get();

            if ($disciplinas->count() > 0) {
                $valor_total = $disciplinas->sum('pivot.nota_final');
                $valor_final = $valor_total / $disciplinas->count();

                $this->areas()->syncWithoutDetaching([$area->codigo => ['valor_notas' => $valor_final]]);
            }
        }
        $this->sugerir();
    }


    private function makeAttachDataForAreasWithValues($areas, $existingPivotData, $valorKey)
    {
        $attachData = [];

        foreach ($areas as $area) {
            $pivotData = [
                $area->codigo => [
                    $valorKey => config("valor_aluno_area.$valorKey")
                ]
            ];

            if ($existingPivotData->isEmpty()) {
                $attachData += $pivotData;
            } else {
                $attachData += [$area->codigo => [$valorKey => DB::raw($valorKey . ' + ' . config("valor_aluno_area.$valorKey"))]];
            }
        }
        return $attachData;
    }


    public function attachAreasWithValues($areas, $valorKey)
    {
        $existingPivotData = $this->areas()
            ->whereIn('area_codigo', $areas->pluck('codigo'))
            ->get();

        $attachData = self::makeAttachDataForAreasWithValues($areas, $existingPivotData, $valorKey);
        $this->areas()->syncWithoutDetaching($attachData);
        $this->sugerir();
    }

    public function AttributeAlunoAreaByAcervo($acervo)
    {
        $this->attachAreasWithValues($acervo->areas, 'valor_acervos');
    }

    public function attributeAtivExtra($ativExtra)
    {
        $this->ativExtra()->attach($ativExtra);
        $this->attachAreasWithValues($ativExtra->areas, 'valor_atividades');
    }

    private function calculateValorFinal($area)
    {
        return  $area->pivot->valor_notas
            + $area->pivot->valor_acervos
            + $area->pivot->valor_atividades
            + $area->pivot->valor_respondido;
    }


    private function getAlunoAreaWithValorFinal()
    {
        $aluno_area_final = collect([]);
        foreach ($this->areas as $area) {
            $valor_final = self::calculateValorFinal($area);
            $aluno_area_final->push(['area_codigo' => $area->pivot->area_codigo, 'valor_final' => $valor_final]);
        }
        return $aluno_area_final;
    }


    private function checkAlunoAreaWithParametros($model, $aluno_area_valor_final)
    {
        $sugere = true;
        foreach ($model->parametros as $parametro) {
            $aluno_area = $aluno_area_valor_final->where('area_codigo', $parametro->area_codigo)->first();

            if (!$aluno_area) {
                $sugere = false;
                continue;
            }
            if ($aluno_area['valor_final'] < $parametro->valor) {
                $sugere = false;
                continue;
            }
        }
        return $sugere;
    }


    private function sugerirCursos($aluno, $aluno_area_valor_final)
    {
        $cursos = Curso::whereNotIn(
            'id',
            $aluno->cursosSugeridos()->pluck('sugerido_id')
        )->get();
        foreach ($cursos as $curso) {
            $sugere = true;
            $sugere = self::checkAlunoAreaWithParametros($curso, $aluno_area_valor_final);
            if ($sugere) {
                $aluno->cursosSugeridos()->attach($curso);
            }
        }
    }

    private function sugerirAtivExtra($aluno, $aluno_area_valor_final)
    {
        $cursos = AtividadeExtra::whereNotIn(
            'id',
            $aluno->ativExtraSugeridos()->pluck('sugerido_id')
        )->get();
        foreach ($cursos as $curso) {
            $sugere = true;
            $sugere = self::checkAlunoAreaWithParametros($curso, $aluno_area_valor_final);
            if ($sugere) {
                $aluno->ativExtraSugeridos()->attach($curso);
            }
        }
    }


    public function sugerir()
    {
        $aluno_area_valor_final = $this->getAlunoAreaWithValorFinal();
        self::sugerirCursos($this, $aluno_area_valor_final);
        self::sugerirAtivExtra($this, $aluno_area_valor_final);
    }
}
