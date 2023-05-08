<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAcervo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'tipo_de_acervo';

    protected $fillable = [
        'tipo',
        'multa'
    ];
}
