<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    use HasFactory;

    protected $fillable = [
        'acervo_id',
        'bibliotecario_id',
        'leitor_id',
        'data_emprestimo',
        'data_devolucao'
    ];

    public function multa()
    {
        return $this->morphOne(Multa::class, 'multas');
    }


    public function acervo()
    {
        return $this->hasOne(Acervo::class);
    }


    public function bibliotecario()
    {
        return $this->hasOne(Pessoa::class, 'id', 'bibliotecario_id');
    }


    public function leitor()
    {
        return $this->hasOne(Pessoa::class, 'id', 'leitor_id');
    }
}
