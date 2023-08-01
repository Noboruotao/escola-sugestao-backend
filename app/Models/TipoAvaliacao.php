<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAvaliacao extends Model
{
    use HasFactory;

    protected $table = 'tipos_de_avaliacoes';
    protected $fillable = ['nome'];
}
