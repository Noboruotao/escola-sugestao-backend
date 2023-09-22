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
        return $this->hasMany(Classe::class, 'professor_id');
    }


    public function disciplinas($active = true)
    {
        return $this->classes->where('ativo', $active)->map(function ($class) {
            return $class->disciplina;
        });
    }


    public function getDisciplinas(
        $page,
        $pageSize,
        $search,
        $active = true
    ) {
        $query = $this->classes->where('ativo', $active)->map(function ($class) {
            return $class->disciplina;
        });

        return [
            'values' => $query->slice($page * $pageSize, $pageSize),
            'count' => $query->count()
        ];
    }


    public function attributeNota($aluno_id, $classe_id, $tipo_avaliacao_id, $nota)
    {
        $aluno = Aluno::find($aluno_id);
        $classe = Classe::where('id', $classe_id)
            ->where('professor_id', auth()->user()->id)
            ->first();
        $tipo_avaliacao = TipoAvaliacao::find($tipo_avaliacao_id);


        if (!$aluno || !$classe || !$tipo_avaliacao) {
            return ['success' => false, 'message' => 'Valor Inválido.'];
        }

        $nova_nota = Nota::create([
            'aluno_id' => $aluno->id,
            'tipo_avaliacao_id' => $tipo_avaliacao->id,
            'disciplina_id' => $classe->disciplina->id,
            'nota' => $nota,
            'classe_id' => $classe->id
        ]);

        $aluno->AttributeAlunoAreaByNota($classe->disciplina);

        return ['success' => true, 'data' => $nova_nota];
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



    public static function makeNotaFinal($aluno_id, $classe_id, $nota_final)
    {
        $aluno = Aluno::find($aluno_id);
        $classe = Classe::where('id', $classe_id)
            ->where('professor_id', auth()->user()->id)
            ->first();


        if (!$aluno || !$classe || !$nota_final) {
            return ['success' => false, 'message' => 'Valor Inválido.'];
        }

        $disciplina = $aluno->disciplinas()
            ->where('id', $classe->disciplina->id)
            ->first();

        $disciplina->pivot->nota_final = $nota_final;
        $disciplina->pivot->situacao_id = self::verificarAprovacao($nota_final);

        $disciplina->pivot->save();

        return [
            'success' => true,
            'aluno' => $aluno,
            'classse' => $classe,
            'nota_final' => $nota_final,
            'disciplina' => $disciplina,
        ];
    }
}
