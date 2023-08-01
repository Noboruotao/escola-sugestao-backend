<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplinaSituacao extends Model
{
    use HasFactory;

    protected $table = 'situacao_da_disciplina';
    protected $fillable = ['nome'];
}