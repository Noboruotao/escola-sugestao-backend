<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'nome', 
        'nacionalidade_id', 
        'data_de_nascimento', 
        'data_de_falecimento'
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'data_de_nascimento' => 'datetime',
        'data_de_falecimento' => 'datetime'
    ];


    public function nacionalidade()
    {
        return $this->belongsTo(Nacionalidade::class, 'nacionalidade_id', 'id');
    }
}
