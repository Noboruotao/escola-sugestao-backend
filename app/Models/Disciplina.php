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



    public function hasArea($nome)
    {
        $areas = $this->areas();

        if( is_string($nome) )
        {
            return $areas->where('nome', $nome)->first();
        }
    }
}
