<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['id', 'ano_id', 'situacao_id'];

    /**
     * acessar os dados de Pessoa com mesmo id
     */
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id', 'id');
    }


    public function ano()
    {
        return $this->belongsTo(Ano::class, 'ano_id', 'id');
    }


    public function situacao()
    {
        return $this->belongsTo(SituacaoAluno::class, 'situacao_id', 'id');
    }


    public function disciplinas()
    {
        return $this->belongsToMany(Disciplina::class)->withPivot('situacao_id', 'nota_final');
    }


    public function areas()
    {
        return $this->belongsToMany(AreasDeConhecimento::class, 'aluno_areas_de_conhecimento')->withPivot('valor_calculado_por_notas', 'valor_calculado_pelo_emprestimo_de_acervo', 'valor_respondido_pelo_aluno');
    }


    public function atividades_extracurriculares()
    {
        return $this->belongsToMany(AtividadesExtracurriculares::class)->withPivot('ativo');
    }


    public function getAlunoAreaByDisciplina()
    {
        $disciplinas = $this->disciplinas;
        $areas = collect();
        foreach($disciplinas as $disciplina)
        {
            $areas = $areas->merge($disciplina->areas->diff($areas));
        }
        return $areas;
    }
}
