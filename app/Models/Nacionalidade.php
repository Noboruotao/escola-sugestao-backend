<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nacionalidade extends Model
{
    use HasFactory;
    public $timestamps = false;


    public function idioma()
    {
        return $this->belongsTo(Idioma::class, 'idioma_id', 'id');
    }
}
