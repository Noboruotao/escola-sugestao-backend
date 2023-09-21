<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAvaliacao extends Model
{
    use HasFactory;

    public const P1 = 1;
    public const P2 = 2;
    public const P_SUB = 4;

    protected $table = 'tipos_avaliacoes';
    protected $fillable = ['nome'];
}
