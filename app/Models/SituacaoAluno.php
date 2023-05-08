<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SituacaoAluno extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'situacao_aluno';

    protected $fillable = [
        'situacao'
    ];
    
}
