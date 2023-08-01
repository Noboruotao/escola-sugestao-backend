<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunoSituacao extends Model
{
    use HasFactory;

    protected $table = 'situacao_aluno';
    protected $fillable = ['situacao'];
}
