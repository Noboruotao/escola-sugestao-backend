<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;
    protected $fillable = [
        'classe_id',
        'dia_semana',
        'horario'
    ];


    public function classe()
    {
        return $this->hasOne(Classe::class);
    }
}
