<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;


    public function areas()
    {
        return $this->belongsToMany(AreasDeConhecimento::class);
    }


    public function anos()
    {
        return $this->belongsToMany(Ano::class);
    }


}
