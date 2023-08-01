<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunoAreasDeConhecimento extends Pivot
{
    protected $table = 'aluno_areas_de_conhecimento';

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function areasDeConhecimento()
    {
        return $this->belongsTo(AreaConhecimento::class);
    }
}