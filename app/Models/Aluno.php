<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'periodo_id',
        'situacao_id'
    ];


    public function pessoa()
    {
        return $this->hasOne(Pessoa::class, 'id', 'id');
    }


    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }


    public function situacao()
    {
        return $this->belongsTo(AlunoSituacao::class);
    }


    public function bolsas()
    {
        return $this->hasMany(Bolsa::class);
    }


    public function responsavel()
    {
        return $this->belongsToMany(Pessoa::class, 'responsavel', 'responsavel_id', 'aluno_id');
    }


    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }


    public function cursosSugeridos()
    {
        return $this->morphedByMany(Curso::class, 'sugeridos');
    }


    public function ativExtraSugeridos()
    {
        return $this->morphedByMany(AtividadeExtra::class, 'sugeridos');
    }


    public function ativExtra()
    {
        return $this->belongsToMany(AtividadeExtra::class, 'aluno_atividades_extracurriculares', 'atividades_extracurriculares_id', 'aluno_id');
    }


    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class, 'aluno_Disciplina')
            ->using(AlunoDisciplina::class)
            ->withPivot('situacao_id', 'nota_final');
    }


    public function areasDeConhecimento()
    {
        return $this->belongsToMany(AreaConhecimento::class, 'aluno_areas_de_conhecimento')
            ->using(AlunoAreasDeConhecimento::class)
            ->withPivot('valor_notas', 'valor_acervos', 'valor_atividades', 'valor_respondido');
    }
}
