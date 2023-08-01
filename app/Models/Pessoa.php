<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pessoa extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'primeiro_nome',
        'ultimo_nome',
        'email',
        'data_nascimento',
        'genero',
        'cpf',
        'rg',
        'telefone_1',
        'telefone_2',
        'senha',
        'foto'
    ];

    protected $hidden = [
        'primeiro_nome',
        'ultimo_nome',
        'data_nascimento',
        'genero',
        'telefone_1',
        'telefone_2',
        'senha',
        'foto'
    ];

    public function enderecos()
    {
        return $this->hasMany(Endereco::class);
    }


    public function professor()
    {
        return $this->hasOne(Professor::class, 'id', 'id');
    }
}
