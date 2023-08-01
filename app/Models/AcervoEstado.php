<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcervoEstado extends Model
{
    use HasFactory;

    protected $table = 'estado_do_acervo';
    protected $fillable = ['estado'];
}