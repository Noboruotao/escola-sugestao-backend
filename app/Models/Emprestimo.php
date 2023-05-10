<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprestimo extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_de_emprestimo',
        'data_de_devolucao'
    ];


    public function acervo()
    {
        return $this->belongsTo(Acervo::class, 'acervo_id', 'id');
    }


    public function bibliotecario()
    {
        return $this->belongsTo(Pessoa::class, 'bibliotecario_id', 'id');
    }


    public function leitor()
    {
        return $this->belongsTo(Pessoa::class, 'leitor_id', 'id');
    }
}
