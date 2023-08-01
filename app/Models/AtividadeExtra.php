<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeExtra extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'tipo_id',
        'ativo'
    ];

    public function ativExtraSugeridas()
    {
        return $this->morphToMany(Aluno::class, 'sugeridos');
    }


    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'aluno_atividades_extracurriculares', 'aluno_id', 'atividades_extracurriculares_id');
    }


    public function parametros()
    {
        return $this->morphMany(Parametro::class, 'model');
    }
}
