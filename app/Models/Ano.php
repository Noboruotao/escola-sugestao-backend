<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ano extends Model
{
    use HasFactory;


    public function nivelEscolar()
    {
        return $this->belongsTo(NivelEscolar::class, 'nivel_escolar_id', 'id');
    }


    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }


    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class);
    }
}
