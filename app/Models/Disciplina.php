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


    public function areas()
    {
        return $this->morphToMany(AreaConhecimento::class, 'model', 'model_has_areas', 'model_id', 'area_codigo');
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


    public static function getDisiplinas($page, $pageSize, $search)
    {
        $query = self::offset($page * $pageSize)
            ->with('periodos')
            ->limit($pageSize)
            ->when($search, function ($query) use ($search) {
                return $query->where('nome', 'like', '%' . $search . '%');
            });

        return ['values' => $query->get(), 'count' => $query->count()];
    }
}
