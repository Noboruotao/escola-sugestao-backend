<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nacionalidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nacionalidade',
        'idioma_oficial_id'
    ];


    public function idioma()
    {
        return $this->hasOne(Idioma::class);
    }
}
