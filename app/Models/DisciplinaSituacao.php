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


    public static function getSituacoesDisciplina()
    {
        return self::all();
    }


    public static function createSituacao($nome)
    {
        return self::create(['nome' => $nome]);
    }


    public static function deleteSituacao($id)
    {
        $situacao = self::find($id);
        if (!$situacao) {
            return false;
        }
        $situacao->delete();
        return true;
    }
}
