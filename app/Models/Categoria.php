<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['categorias'];


    public function acervos()
    {
        return $this->hasMany(Acervo::class, 'categoria_id');
    }
}
