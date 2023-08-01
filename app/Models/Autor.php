<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;

    protected $fillabel = [
        'nome',
        'nacionalidade_id',
        'data_de_nascimento',
        'data_de_falecimento'
    ];


    public function nacionalidade()
    {
        return $this->hasOne(Nacionalidade::class);
    }
}
