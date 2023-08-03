<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'carga_horaria'];

    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'aluno_Disciplina')
            ->using(AlunoDisciplina::class)
            ->withPivot('situacao_id', 'nota_final');
    }


    public function notas()
    {
        return $this->hasMany(Nota::class);
    }


    public function periodos()
    {
        return $this->belongsToMany(Periodo::class, 'disciplina_periodo', 'disciplina_id', 'periodo_id');
    }


    public function materialSugeridos()
    {
        return $this->belongsToMany(Acervo::class, 'materiais_sugeridos');
    }
}
