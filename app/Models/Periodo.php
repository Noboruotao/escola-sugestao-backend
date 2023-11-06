<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nivel_escolar_id',
        'periodo'
    ];

    public function disciplinas()
    {
        return $this->hasMany(Disciplina::class);
    }

    public function nivelEscolar()
    {
        return $this->belongsTo(NivelEscolar::class);
    }


    public function alunos()
    {
        return $this->hasMany(
            Aluno::class,
            'periodo_id',
            'id'
        );
    }
}
