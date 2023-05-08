<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoAcervo extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'estado_do_acervo';

    protected $fillable = ['estado'];
}
