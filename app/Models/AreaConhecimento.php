<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaConhecimento extends Model
{
    use HasFactory;

    protected $table = 'areas_de_conhecimentos';
    protected $fillable = ['codigo', 'nome'];


    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'aluno_areas_de_conhecimento')
            ->using(AlunoAreasDeConhecimento::class)
            ->withPivot('valor_notas', 'valor_acervos', 'valor_atividades', 'valor_respondido');
    }


}
