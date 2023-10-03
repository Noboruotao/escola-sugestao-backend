<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplinaSituacao extends Model
{
    use HasFactory;

    protected $table = 'situacao_disciplina';
    protected $fillable = ['nome'];
    public $timestamps = false;


    public const APROVADO = 1;
    public const REPROVADO = 2;
    public const MATRICULADO = 3;
    public const CANCELADO = 4;
    public const EM_ANDAMENTO = 5;
    public const TRANCADO = 6;
    public const DISPENSADO = 7;


    public function getSituacoesDisciplina()
    {
        return self::all();
    }


    public function createSituacao($nome)
    {
        return self::create(['nome' => $nome]);
    }


    public function deleteSituacao($id)
    {
        $situacao = self::find($id);
        if (!$situacao) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possivel deleter esta permissão'
            ], 401);
        }
        $situacao->delete();
        return response()->json([
            'success' => true,
            'message' => 'Situação deletada com sucesso'
        ]);
    }
}
