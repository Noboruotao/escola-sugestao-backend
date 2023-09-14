<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplinaSituacao extends Model
{
    use HasFactory;

    protected $table = 'situacao_disciplina';
    protected $fillable = ['nome'];

    public const Aprovado = 1;
    public const Reprovado = 2;
    public const Matriculado = 3;
    public const Cancelado = 4;
    public const EmAndamento = 5;
    public const Trancado = 6;
    public const Dispensado = 7;
}
