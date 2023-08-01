<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao'
    ];

    public function pessoasSugeridas()
    {
        return $this->morphToMany(Aluno::class, 'sugeridos');
    }


    public function parametros()
    {
        return $this->morphMany(Parametro::class, 'model');
    }
}
