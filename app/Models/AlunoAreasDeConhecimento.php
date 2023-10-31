<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class AlunoAreasDeConhecimento extends Pivot
{
    protected $table = 'aluno_areas_de_conhecimento';

    public function aluno()
    {
        return $this->belongsTo(
            Aluno::class,
            'aluno_id',
            'id'
        );
    }

    public function area()
    {
        return $this->belongsTo(
            AreaConhecimento::class,
            'area_codigo',
            'codigo'
        );
    }
}
