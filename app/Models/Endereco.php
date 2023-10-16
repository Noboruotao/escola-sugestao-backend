<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Pessoa;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'cep',
        'rua',
        'bairro',
        'numero',
        'cidade',
        'uf',
        'complemento'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function pessoas()
    {
        return $this->belongsToMany(Pessoa::class);
    }
}
