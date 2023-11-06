<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'experiencia_profissional'
    ];

    public function classes()
    {
        return $this->hasMany(
            Classe::class,
            'professor_id'
        );
    }

    public function pessoa()
    {
        return $this->belongsTo(
            Pessoa::class,
            'id'
        );
    }


    public function disciplinas($active = true)
    {
        return $this->classes->where('ativo', $active)
            ->map(function ($classe) {
                return $classe->disciplina;
            });
    }

    public function getDisciplinas(
        $page,
        $pageSize,
        $search,
        $active = 1,
        $sortColumn,
        $sortOrder
    ) {

        if ($this->classes->where('ativo', $active)->count() < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Disciplina Não Encontrado'
            ], 400);
        }

        $query = $this->classes
            ->where('ativo', $active)
            ->filter(function ($classe) use ($search) {
                return str_contains(
                    $classe->disciplina->nome,
                    $search
                );
            })->map(function ($classe) {
                return $classe->disciplina;
            });

        $query = ($sortOrder == 'asc')
            ? $query->sortBy($sortColumn)
            : $query->sortByDesc($sortColumn);

        $disciplinas = $query->skip($page * $pageSize)
            ->take($pageSize);

        foreach ($disciplinas as $disciplina) {
            $disciplina->periodo;
        }

        return response()->json([
            'success' => true,
            'data' => $disciplinas->values(),
            'count' => $query->count()
        ]);
    }


    public function attributeNota(
        $aluno_id,
        $classe_id,
        $tipo_avaliacao_id,
        $nota
    ) {
        $aluno = Aluno::find($aluno_id);

        $classe = auth()->user()
            ->professor
            ->classes()
            ->where('id', $classe_id)
            ->first();
        $tipo_avaliacao = TipoAvaliacao::find($tipo_avaliacao_id);


        if (!$aluno || !$classe || !$tipo_avaliacao) {
            return [
                'success' => false,
                'message' => 'Valor Inválido.'
            ];
        }

        $nova_nota = Nota::create([
            'aluno_id' => $aluno->id,
            'tipo_avaliacao_id' => $tipo_avaliacao->id,
            'disciplina_id' => $classe->disciplina->id,
            'nota' => $nota,
            'classe_id' => $classe->id
        ]);

        $aluno->AttributeAlunoAreaByNota($classe->disciplina);

        return [
            'success' => true,
            'data' => $nova_nota
        ];
    }


    private static function verificarAprovacao($nota)
    {
        $linha_para_aprovacao = config('parametros.nota_para_aprovacao');

        if ($nota >= $linha_para_aprovacao) {
            return DisciplinaSituacao::APROVADO;
        } else {
            return DisciplinaSituacao::REPROVADO;
        }
    }


    public  function makeNotaFinal(
        $aluno_id,
        $classe_id,
        $nota_final
    ) {
        $aluno = Aluno::find($aluno_id);
        $classe = Classe::where('id', $classe_id)
            ->where('professor_id', auth()->user()->id)
            ->first();


        if (!$aluno || !$classe || !$nota_final) {
            return response()->json([
                'success' => false,
                'message' => 'Valor Inválido.'
            ], 400);
        }

        $disciplina = $aluno->disciplinas()
            ->where('id', $classe->disciplina->id)
            ->first();

        $disciplina->pivot->nota_final = $nota_final;
        $disciplina->pivot
            ->situacao_id = self::verificarAprovacao($nota_final);

        $disciplina->pivot->save();
        return response()->json([
            'success' => true,
            'data' => $disciplina,
        ]);
    }

    public function getAlunosClasse($classe_id)
    {
        $classe = $this->classes()
            ->where('id', $classe_id)
            ->first();

        if (!$classe) {
            return response()->json([
                'success' => false,
                'message' => 'Casse Não encontrado.'
            ], 404);
        }

        $alunos = $classe->alunos;
        return response()->json([
            'success' => true,
            'data' => $alunos
        ]);
    }
}
