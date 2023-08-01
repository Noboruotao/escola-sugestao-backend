<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $fillable = [
        'aluno_id',
        'tipo_de_avaliacao_id',
        'disciplina_id',
        'nota'
    ];


    public function aluno()
    {
        return $this->hasOne(ALuno::class);
    }


    public function tipo()
    {
        return $this->hasOne(TipoAvaliacao::class);
    }


    public function disciplina()
    {
        return $this->hasOne(Disciplina::class);
    }
}
