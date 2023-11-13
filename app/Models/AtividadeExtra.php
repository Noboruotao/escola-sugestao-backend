<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AreaConhecimento;

class AtividadeExtra extends Model
{
    use HasFactory;

    protected $table = 'atividade_extracurriculares';
    protected $fillable = [
        'nome',
        'descricao',
        'tipo_id',
        'ativo'
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function ativExtraSugeridas()
    {
        return $this->morphToMany(
            Aluno::class,
            'sugeridos'
        );
    }


    public function alunos()
    {
        return $this->belongsToMany(
            Aluno::class,
            'aluno_ativExtra',
            'ativExtra_id',
            'aluno_id'
        )
            ->with('pessoa')
            ->withPivot('ativo');
    }


    public function parametros()
    {
        return $this->morphMany(
            Parametro::class,
            'model'
        );
    }


    public function areas()
    {
        return $this->morphToMany(
            AreaConhecimento::class,
            'model',
            'model_has_areas',
            'model_id',
            'area_codigo'
        );
    }

    public function tipo()
    {
        return $this->belongsTo(AtivExtraTipo::class);
    }


    public function getAtivExtras(
        $page,
        $limit,
        $search,
        $sortColumn = 'nome',
        $order = 'asc',
        $tipo
    ) {
        $query = self::orderBy(
            $sortColumn,
            $order == ''
                ? 'asc'
                : $order
        )
            ->when($search, function ($query) use ($search) {
                return $query->where(
                    'nome',
                    'like',
                    '%' . $search . '%'
                );
            })
            ->when($tipo != '', function ($query) use ($tipo) {
                return $query->where('tipo_id', $tipo);
            })
            ->with('tipo');

        $count = $query->count();
        $value = $query->offset($page * $limit)
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $value,
            'count' => $count,
        ]);
    }


    public function getAtivExtraDetail($id)
    {
        $info =
            self::where('id', $id)
            ->with('tipo')
            ->when(
                !auth()->user()->hasRole('Aluno'),
                function ($query) {
                    return $query->with('alunos');
                }
            )
            ->first();


        if ($info == null) {
            return response()->json([
                'success' => false,
                'message' => 'Atividade Extracurricular Não Encontrado'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $info
        ]);
    }


    public function attributeAtivExtraToAluno(
        $aluno_id,
        $ativExtra_id
    ) {
        $aluno = Aluno::find($aluno_id);
        $ativiExtra = self::find($ativExtra_id);

        if (!$aluno || !$ativiExtra) {
            return response()->json([
                'success' => false,
                'message' => 'Aluno ou Atividade Não Encontrada.'
            ], 404);
        }

        return $aluno->attributeAtivExtra($ativiExtra);
    }

    public function getAlunos(
        $id,
        $page,
        $pageSize
    ) {
        $ativExtra = self::find($id);

        if (
            !$ativExtra || $ativExtra->alunos
            ->count() == 0
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Sem Alunos Atribuídos.'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => Pessoa::select([
                'id',
                'nome'
            ])
                ->orderBy('nome')
                ->whereIn(
                    'id',
                    $ativExtra->alunos()
                        ->where('ativo', 1)
                        ->pluck('id')
                        ->toArray()
                )
                ->skip($page * $pageSize)
                ->take($pageSize)
                ->get(),
            'count' => $ativExtra->alunos
                ->where('pivot.ativo', 1)
                ->count()
        ]);
    }


    public function removeAlunoFromAtivExtra(
        $aluno_id,
        $ativExtra_id
    ) {
        $ativExtra = self::find($ativExtra_id);

        $aluno = Aluno::find($aluno_id);

        if ($ativExtra_aluno = $ativExtra->alunos()
            ->where('aluno_id', $aluno->id)
            ->first()
        ) {
            $ativExtra_aluno->pivot->ativo = 0;
            $ativExtra_aluno->pivot->save();


            return response()->json([
                'success' => true,
                'data' => $ativExtra->alunos->where('pivot.ativo', 1),
                'count' => $ativExtra->alunos->where('pivot.ativo', 1)
                    ->count()

            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Remoção do aluno sem Sucesso. Verifique a Atividade Extracurricular ou Aluno.'
        ], 400);
    }
}
