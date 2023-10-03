<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Acervo;

class AreaConhecimento extends Model
{
    use HasFactory;

    protected $table = 'areas_de_conhecimentos';
    protected $primaryKey = 'codigo';
    protected $keyType = 'string';

    protected $fillable = ['codigo', 'nome'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];


    public function alunos()
    {
        return $this->belongsToMany(
            Aluno::class,
            'aluno_areas_de_conhecimento',
            'area_codigo',
            'aluno_id',
            'codigo',
            'id'
        )
            ->using(AlunoAreasDeConhecimento::class)
            ->withPivot('valor_notas', 'valor_acervos', 'valor_atividades', 'valor_respondido');
    }


    public function disciplinas(){
        return $this->morphedByMany(Acervo::class, 'model', 'model_has_areas', 'area_codigo', 'model_id');
    }


    public function acervos()
    {
        return $this->morphedByMany(Acervo::class, 'model', 'model_has_areas', 'area_codigo', 'model_id');
    }


    public function getDescendantAreas()
    {
        $codigo = $this->codigo;
        $descendants = collect();

        do {
            $codigo = substr($codigo, 0, -1);
            $descendants = $descendants->merge(AreaConhecimento::where('codigo', $codigo)->get());
        } while ($codigo != '');

        return $descendants;
    }

    public function getAncestorAreas()
    {
        return AreaConhecimento::where('codigo', 'like', $this->codigo . '%')->get();
    }

    public function getRelatedAreas()
    {
        return $this->getDescendantAreas()->push($this)->merge($this->getAncestorAreas())->unique('codigo');
    }
}
