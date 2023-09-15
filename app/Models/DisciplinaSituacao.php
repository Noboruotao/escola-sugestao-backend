<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplinaSituacao extends Model
{
    use HasFactory;

    protected $table = 'situacao_disciplina';
    protected $fillable = ['nome'];

    public const APROVADO = 1;
    public const REPROVADO = 2;
    public const MATRICULADO = 3;
    public const CANCELADO = 4;
    public const EM_ANDAMENTO = 5;
    public const TRANCADO = 6;
    public const DISPENSADO = 7;
}
