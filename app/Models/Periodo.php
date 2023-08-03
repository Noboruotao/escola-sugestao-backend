<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;

    protected $fillable = ['nivel_escolar_id', 'periodo'];

    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'disciplina_periodo', 'periodo_id', 'disciplina_id');
    }
}
