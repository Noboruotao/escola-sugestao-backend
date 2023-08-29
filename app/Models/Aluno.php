<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

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
        return $this->morphedByMany(Curso::class, 'sugeridos');
    }


    public function ativExtraSugeridos()
    {
        return $this->morphedByMany(AtividadeExtra::class, 'sugeridos');
    }


    public function ativExtra()
    {
        return $this->belongsToMany(AtividadeExtra::class, 'aluno_ativExtra', 'ativExtra_id', 'aluno_id');
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
    }


    public function attachAreasWithValues($areas, $valorKey)
    {
        $existingPivotData = $this->areas()
            ->whereIn('area_codigo', $areas->pluck('codigo'))
            ->get();

        $attachData = [];

        foreach ($areas as $area) {
            $pivotData = [$area->codigo => [$valorKey => config("valor_aluno_area.$valorKey")]];

            if ($existingPivotData->isEmpty()) {
                $attachData += $pivotData;
            } else {
                $attachData += [$area->codigo => [$valorKey => DB::raw($valorKey . ' + ' . config("valor_aluno_area.$valorKey"))]];
            }
        }
        $this->areas()->syncWithoutDetaching($attachData);
    }

    public function AttributeAlunoAreaByAcervo($acervo)
    {
        $this->attachAreasWithValues($acervo->areas, 'valor_acervos');
    }

    public function attributeAtivExtra($ativExtra)
    {
        $this->ativExtra()->attach($ativExtra);
        $this->attachAreasWithValues($ativExtra->areas(), 'valor_atividades');
    }
}
