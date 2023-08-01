<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcervoTipo extends Model
{
    use HasFactory;

    protected $table = 'tipo_de_acervo';
    protected $fillable = ['tipo', 'multa'];


    public function acervos()
    {
        return $this->hasMany(Acervo::class, 'tipo_id');
    }
}
