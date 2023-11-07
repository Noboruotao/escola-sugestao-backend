<?php

namespace App\Models;

use Carbon\Carbon;
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
        return $this->belongsTo(
            Pessoa::class,
            'id',
            'id'
        );
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
        return $this->belongsToMany(
            Bolsa::class,
            'aluno_bolsa',
            'aluno_id',
            'bolsa_id'
        );
    }


    public function bolsaValor()
    {
        return $this->bolsas()->sum('valor');
    }


    public function responsavel()
    {
        return $this->belongsToMany(
            Pessoa::class,
            'responsavel',
            'aluno_id',
            'responsavel_id'
        );
    }


    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }


    public function cursosSugeridos()
    {
        return $this->morphedByMany(
            Curso::class,
            'sugerido',
            'sugeridos',
            'aluno_id',
            'sugerido_id',
        )->whereNull('sugeridos.desaparecer');
    }


    public function ativExtraSugeridos()
    {
        return $this->morphedByMany(
            AtividadeExtra::class,
            'sugerido',
            'sugeridos',
            'aluno_id',
            'sugerido_id',
        )
            ->whereNull('sugeridos.desaparecer')
            ->with('tipo');
    }


    public function ativExtra()
    {
        return $this->belongsToMany(
            AtividadeExtra::class,
            'aluno_ativExtra',
            'aluno_id',
            'ativExtra_id'
        )
            ->withPivot('ativo');
    }


    public function classes()
    {
        return $this->belongsToMany(Classe::class)
            ->withPivot([
                'presenca',
                'faltas'
            ]);;
    }


    public function disciplinas()
    {
        return $this->belongsToMany(
            Disciplina::class,
            'aluno_Disciplina'
        )
            ->using(AlunoDisciplina::class)
            ->with('periodo')
            ->withPivot(
                'situacao_id',
                'nota_final'
            );
    }


    public function areas()
    {
        return $this->belongsToMany(
            AreaConhecimento::class,
            'aluno_areas_de_conhecimento',
            'aluno_id',
            'area_codigo',
            'id',
            'codigo',
            'areas'
        )
            ->using(AlunoAreasDeConhecimento::class)
            ->withPivot(
                'valor_notas',
                'valor_acervos',
                'valor_atividades',
                'valor_respondido'
            );
    }

    private function getDisciplinasWithArea($area)
    {
        return $this->disciplinas()
            ->whereHas('areas', function ($query) use ($area) {
                $query->where('area_codigo', $area->codigo);
            })
            ->get();
    }


    public function notas()
    {
        return $this->hasMany(
            Nota::class,
            'aluno_id',
            'id'
        );
    }


    public function getCursosSugeridos(
        $page,
        $limit,
        $search,
        $sortColumn,
        $sortOrder
    ) {
        $user = auth()->user();
        return $user->aluno->cursosSugeridos
            ->when($search, function ($query) use ($search) {
                return $query
                    ->filter(function ($curso) use ($search) {
                        return stripos($curso['nome'], $search) !== false ||
                            stripos($curso['descricao'], $search) !== false;
                    });
            });
    }

    public function getAtivExtraSugerido(
        $page,
        $limit,
        $search,
        $sortColumn,
        $sortOrder,
        $tipo
    ) {
        $user = auth()->user();
        return $user->aluno
            ->ativExtraSugeridos
            ->when($tipo != '', function ($query) use ($tipo) {
                return $query->where('tipo_id', $tipo);
            })
            ->when($search, function ($query) use ($search) {
                return $query->filter(function ($ativ) use ($search) {
                    return stripos($ativ['nome'], $search) !== false ||
                        stripos($ativ['descricao'], $search) !== false;
                });
            });
    }


    public static function getDisciplinaNotas(
        $aluno,
        $disciplina_id,
        $todas = false
    ) {
        $disciplina = Disciplina::find($disciplina_id);

        $classe = null;
        if (!$todas) {
            $classe = $aluno->classes
                ->where('disciplina_id', $disciplina->id)
                ->last();
        }
        $notasQuery = Nota::where('aluno_id', $aluno->id)
            ->where('disciplina_id', $disciplina->id)
            ->orderBy('tipo_avaliacao_id');

        if ($classe) {
            $notasQuery->where('classe_id', $classe->id);
        }

        $notas = $notasQuery
            ->with('tipo')
            ->get();

        $multipleClasses = $aluno->classes
            ->where('disciplina_id', $disciplina->id)
            ->count() > 1;

        $activeClassExists = $aluno->classes
            ->where('disciplina_id', $disciplina->id)
            ->has(['ativo' => 1]);

        $nota_final = ($multipleClasses && $activeClassExists)
            ? null
            : $aluno->disciplinas
            ->where('id', $disciplina->id)
            ->first()
            ->pivot
            ->nota_final;

        return [
            'success' => true,
            'data' => $notas,
            'nota_final' => $nota_final,
        ];
    }


    public function getCursosPorSituacao($situacao_id)
    {
        return $this->disciplinas
            ->filter(function ($item) use ($situacao_id) {
                return $item['pivot']['situacao_id'] == $situacao_id;
            });
    }


    public function getCursosSugeridosId()
    {
        return $this->cursosSugeridos
            ->pluck('id')
            ->toArray();
    }


    public function disaparecerSugerido(
        $model_id,
        $model_type
    ) {
        $aluno = auth()->user()
            ->aluno;

        if ($model_type == Curso::class) {
            $sugerido = $aluno->cursosSugeridos()
                ->where('sugerido_id', $model_id)
                ->first();
        } else if ($model_type == AtividadeExtra::class) {
            $sugerido = $aluno->ativExtraSugeridos()
                ->where('sugerido_id', $model_id)
                ->first();
        }

        if (!$sugerido) {
            return response()->json([
                'success' => false,
                'message' => 'Dado Não Encontrado'
            ]);
        }

        $sugerido->pivot->desaparecer = Carbon::now()->format('Y-m-d');
        $sugerido->pivot->save();


        return response()->json([
            'success' => true,
            'data' => $sugerido
        ]);
    }


    public function getNotas($aluno_id, $classe_id, $disciplina_id, $todas)
    {
        $user = self::find($aluno_id);
        if ($classe_id) {
            return $user->getClasseNotas($user, $classe_id);
        } else if ($disciplina_id) {
            return self::getDisciplinaNotas($user, $disciplina_id, $todas);
        }
    }

    public static function getClasseNotas($aluno, $classe_id)
    {
        $classe = $aluno->classes()
            ->where('id', $classe_id)
            ->first();

        if (!$classe) {
            return  response()->json([
                'success' => false,
                'message' => 'Classe Não Encontrado'
            ], 404);
        }

        $notas = Nota::where('aluno_id', $aluno->id)
            ->orderBy('tipo_avaliacao_id')
            ->where('classe_id', $classe->id)
            ->with('tipo')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notas,
            'nota_final' => null
        ]);
    }


    public function getDisciplinasBySituacao(
        $page,
        $pageSize,
        $search,
        $situacao_id = DisciplinaSituacao::EM_ANDAMENTO,
        $sortColumn,
        $sortOrder
    ) {
        $query = $this->disciplinas

            ->where('pivot.situacao_id', $situacao_id);

        if ($search) {
            $query = $query
                ->filter(function ($item) use ($search) {
                    return stripos($item['nome'], $search) !== false;
                });
        }

        $query = ($sortOrder == 'asc')
            ? $query->sortBy($sortColumn)
            : $query->sortByDesc($sortColumn);


        $values = $query;

        return response()->json([
            'success' => true,
            'data' => $values
                ->slice(
                    $page * $pageSize,
                    $pageSize
                )
                ->values(),
            'count' => $query->count()
        ]);
    }

    private function AttributeAreaByNota(
        $notas,
        $area
    ) {
        $valor_total = $notas->sum('nota');
        $valor_final = $valor_total / $notas->count();

        $this->areas()
            ->syncWithoutDetaching([
                $area->codigo => [
                    'valor_notas' => $valor_final
                ]
            ]);
    }


    public function AttributeAlunoAreaByNota($disciplina)
    {
        foreach ($disciplina->areas as $area) {
            $disciplinas = $this->getDisciplinasWithArea($area);
            $notas = Nota::getAlunoNotasWithinDisciplinas(
                $this,
                $disciplinas
            );

            if ($notas->count() > 0) {

                $this->AttributeAreaByNota(
                    $notas,
                    $area
                );
            }
        }
        $this->sugerir();
    }


    private function makeAttachDataForAreasWithValues(
        $areas,
        $existingPivotData,
        $valorKey
    ) {
        $attachData = [];

        foreach ($areas as $area) {
            $pivotData = [
                $area->codigo => [
                    $valorKey => config("valor_aluno_area.$valorKey")
                ]
            ];

            if ($existingPivotData->isEmpty()) {
                $attachData += [
                    $area->codigo => [
                        $valorKey => DB::raw(config("valor_aluno_area.$valorKey"))
                    ]
                ];
            } else {
                if ($valorKey === 'valor_respondido') {
                    $attachData += [
                        $area->codigo => [
                            $valorKey => config("valor_aluno_area.valor_respondido")
                        ]
                    ];
                } else {
                    $attachData += [
                        $area->codigo => [
                            $valorKey => DB::raw($valorKey . ' + ' . config("valor_aluno_area.$valorKey"))
                        ]
                    ];
                }
            }
        }
        return $attachData;
    }


    public function attachAreasWithValues(
        $areas,
        $valorKey
    ) {
        $existingPivotData = $this->areas()
            ->whereIn('area_codigo', $areas->pluck('codigo'))
            ->get();

        $attachData = self::makeAttachDataForAreasWithValues(
            $areas,
            $existingPivotData,
            $valorKey
        );
        $this->areas()->syncWithoutDetaching($attachData);
        $this->sugerir();
    }

    public function clearEscolhidos()
    {
        $areas = $this->areas()
            ->where('valor_respondido', '!=', 0)
            ->get();

        if (!$areas->isEmpty()) {
            $syncData = [];

            foreach ($areas as $area) {
                $syncData[$area->codigo] = [
                    'valor_respondido' => 0
                ];
            }

            $this->areas()->syncWithoutDetaching($syncData);
        }
    }

    public function attribuirEscolhasValor($escolhas)
    {
        foreach ($escolhas as $escolha) {
            $area = AreaConhecimento::where('codigo', $escolha)
                ->first();
            $relacionados = $area->getRelatedAreas();
            $this->attachAreasWithValues(
                $relacionados,
                'valor_respondido'
            );
        }
    }


    public function AttributeAlunoAreaByAcervo($acervo)
    {
        $this->attachAreasWithValues($acervo->areas, 'valor_acervos');
    }

    public function attributeAtivExtra($ativExtra)
    {
        if (
            $this->ativExtra
            ->contains($ativExtra) == false
        ) {
            $this->ativExtra()
                ->attach($ativExtra);
            $this->attachAreasWithValues(
                $ativExtra->areas,
                'valor_atividades'
            );
            return response()->json([
                'success' => true,
                'data' => [
                    'aluno' => $this->pessoa->nome,
                    'ativExtra' => $ativExtra->nome
                ]
            ]);
        } else if (
            $this->ativExtra()
            ->where(
                [
                    ['ativExtra_id', $ativExtra->id],
                    ['pivot.ativo', 0]
                ]
            )
        ) {
            $aluno_ativExtra = $this->ativExtra()
                ->where('ativExtra_id', $ativExtra->id)
                ->first();
            $aluno_ativExtra->pivot->ativo = 1;
            $aluno_ativExtra->pivot
                ->save();

            return response()->json([
                'success' => true,
                'message' => 'atividade retomada',
                'data' =>
                [
                    'aluno' => $this->pessoa->nome,
                    'ativExtra' => $ativExtra->nome
                ]
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Este Aluno já está atribuido.'
        ], 400);
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
            $aluno_area_final->push([
                'area_codigo' => $area->pivot->area_codigo,
                'valor_final' => $valor_final
            ]);
        }
        return $aluno_area_final;
    }


    private function checkAlunoAreaWithParametros(
        $model,
        $aluno_area_valor_final
    ) {
        $sugere = true;
        foreach ($model->parametros as $parametro) {
            $aluno_area = $aluno_area_valor_final
                ->where('area_codigo', $parametro->area_codigo)
                ->first();

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


    private function sugerirCursos(
        $aluno,
        $aluno_area_valor_final
    ) {

        if ($this->periodo_id >= config('parametros.periodo_para_comecar_a_sugerir_curso')) {
            $cursos = Curso::whereNotIn(
                'id',
                $aluno->cursosSugeridos()
                    ->pluck('sugerido_id')
            )->get();
            foreach ($cursos as $curso) {
                $sugere = true;
                $sugere = self::checkAlunoAreaWithParametros(
                    $curso,
                    $aluno_area_valor_final
                );
                if ($sugere) {
                    $aluno->cursosSugeridos()
                        ->attach($curso);
                }
            }
        }
    }

    private function sugerirAtivExtra(
        $aluno,
        $aluno_area_valor_final
    ) {
        if ($this->periodo_id >= config('parametros.periodo_para_comecar_a_sugerir_ativExtra')) {

            $cursos = AtividadeExtra::whereNotIn(
                'id',
                $aluno->ativExtraSugeridos()
                    ->pluck('sugerido_id')
            )->get();
            foreach ($cursos as $curso) {
                $sugere = true;
                $sugere = self::checkAlunoAreaWithParametros(
                    $curso,
                    $aluno_area_valor_final
                );
                if ($sugere) {
                    $aluno->ativExtraSugeridos()
                        ->attach($curso);
                }
            }
        }
    }


    public function sugerir()
    {
        $aluno_area_valor_final = $this->getAlunoAreaWithValorFinal();
        self::sugerirCursos(
            $this,
            $aluno_area_valor_final
        );
        self::sugerirAtivExtra(
            $this,
            $aluno_area_valor_final
        );
    }
}
