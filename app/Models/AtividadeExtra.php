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


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
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

    public function tipo()
    {
        return $this->belongsTo(AtivExtraTipo::class);
    }


    public function getAtivExtra($page, $limit, $search)
    {
        $sugeridos_id = [];
        if (auth()->user()->hasRole('Aluno')) {
            $sugeridos_id = auth()->user()
                ->aluno->ativExtraSugeridos
                ->pluck('id')
                ->toArray();
        }

        return self::orderBy('nome')
            ->offset($page * $limit)
            ->limit($limit)
            ->whereNotIn('id', $sugeridos_id)
            ->when($search, function ($query) use ($search) {
                return $query->where('nome', 'like', '%' . $search . '%');
            })
            ->get();
    }
}
