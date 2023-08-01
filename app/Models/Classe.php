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


    public function alunos()
    {
        return $this->belongsToMany(Aluno::class)
            ->withPivot(['presenca', 'faltas']);
    }


    public function aulas()
    {
        return $this->hasMany(Aula::class);
    }
}
