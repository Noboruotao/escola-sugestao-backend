<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcervoEstado extends Model
{
    use HasFactory;

    protected $table = 'estado_acervo';
    
    protected $fillable = ['estado'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
