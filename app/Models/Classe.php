<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'professor_id',
        'disciplina_id',
        'ativo'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];


    public function alunos()
    {
        return $this->belongsToMany(Aluno::class)
            ->withPivot([
                'presenca',
                'faltas'
            ]);
    }


    public function aulas()
    {
        return $this->hasMany(Aula::class);
    }


    public function professor()
    {
        return $this->belongsTo(
            Professor::class,
            'professor_id'
        );
    }

    public function disciplina()
    {
        return $this->belongsTo(
            Disciplina::class,
            'disciplina_id'
        );
    }


    public function getClassesEnableAtivo(
        $ativo,
        $page,
        $pageSize,
        $search,
        $sortColumn,
        $sortOrder
    ) {
        $user = auth()->user();
        $query = ($user->hasRole('Aluno'))
            ? $user->aluno
            ->classes()
            ->where('ativo', $ativo)
            : $user->professor
            ->classes()
            ->where('ativo', $ativo);

        if ($search !== '') {
            $query->whereHas('disciplina', function ($sub_query) use ($search) {
                $sub_query->where('nome', 'like', "%$search%");
            })->orWhere('ano', 'like', "%$search%");
        }

        $qnt = $query->count();
        $classes = $query->with('disciplina')
            ->orderBy($sortColumn, $sortOrder)
            ->offset($page * $pageSize)
            ->limit($pageSize)
            ->get();

        if ($user->hasRole('Aluno')) {
            $classes = self::setAlunoNotasOnClasse($classes);
        }

        return response()->json([
            'success' => true,
            'data' => $classes,
            'count' => $qnt
        ]);
    }

    private static function setAlunoNotasOnClasse($classes)
    {
        $notas = Nota::where('aluno_id', auth()->user()->id)
            ->whereIn('classe_id', $classes->pluck('id')->toArray())
            ->get();

        foreach ($classes as $classe) {
            $classe->p1 = $notas->where('classe_id', $classe->id)
                ->where('tipo_avaliacao_id', TipoAvaliacao::P1)
                ->first()
                ->nota
                ?? null;
            $classe->p2 = $notas->where('classe_id', $classe->id)
                ->where('tipo_avaliacao_id', TipoAvaliacao::P2)
                ->first()
                ->nota
                ?? null;
            $classe->sub = $notas->where('classe_id', $classe->id)
                ->where('tipo_avaliacao_id', TipoAvaliacao::P_SUB)
                ->first()
                ->nota
                ?? null;
        }

        return $classes;
    }


    public function getAlunos($id)
    {
        $classe = self::find($id);
        if (!$classe) {
            return response()->json([
                'success' => false,
                'message' => 'Valor Inválido'
            ], 404);
        }

        $alunos = Pessoa::select([
            'nome',
            'id'
        ])
            ->orderBy('nome')
            ->whereIn(
                'id',
                $classe->alunos->pluck('id')
            )
            ->get();

        foreach ($alunos as $aluno) {
            $aluno->presenca = $aluno
                ->aluno
                ->classes()
                ->where('id', $id)
                ->get()['0']
                ->pivot
                ->presenca;
            $aluno->faltas = $aluno->aluno
                ->classes()
                ->where('id', $id)
                ->get()['0']
                ->pivot
                ->faltas;
        }

        return response()->json([
            'success' => true,
            'data' => $alunos
        ]);
    }


    public function getClasseDetail($classe_id)
    {
        $info = self::with([
            'disciplina',
            'professor.pessoa'
        ])
            ->where('id', $classe_id)
            ->first();

        return $info ? response()->json(
            [
                'success' => true,
                'data' => $info
            ],
            200
        ) : response()->json(
            [
                'success' => false,
                'message' => 'Classe Não Encontrado'
            ],
            404
        );
    }
}
