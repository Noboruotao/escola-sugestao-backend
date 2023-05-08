<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ano extends Model
{
    use HasFactory;

    protected $fillable = ['nivel_escolar_id', 'ano'];

    protected $guarded = ['id'];



    public function nivelEscolar()
    {
        return $this->belongsTo(NivelEscolar::class);
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
