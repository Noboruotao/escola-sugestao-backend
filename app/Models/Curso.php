<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
    ];

    protected $guarded = [
        'id',
    ];

    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:i',
        'updated_at' => 'datetime:d/m/Y H:i',
    ];

    public function areas()
    {
        return $this->belongsToMany(AreasDeConhecimento::class, 'parametros_para_sugerir_curso');
    }


    public function getAreas()
    {
        return $this->areas()->pluck('nome');
    }
}
