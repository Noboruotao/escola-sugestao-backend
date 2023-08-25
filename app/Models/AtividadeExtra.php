<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AreaConhecimento;

class AtividadeExtra extends Model
{
    use HasFactory;

    protected $table = 'atividade_extracurriculares';
    protected $fillable = [
        'nome',
        'tipo_id',
        'ativo'
    ];

    public function ativExtraSugeridas()
    {
        return $this->morphToMany(Aluno::class, 'sugeridos');
    }


    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'aluno_ativExtra', 'aluno_id', 'ativExtra_id');
    }


    public function parametros()
    {
        return $this->morphMany(Parametro::class, 'model');
    }


    public function areas()
    {
        return $this->morphToMany(AreaConhecimento::class, 'model', 'model_has_areas', 'model_id', 'area_codigo');
    }
}
