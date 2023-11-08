<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'carga_horaria'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function alunos()
    {
        return $this->belongsToMany(
            Aluno::class,
            'aluno_Disciplina'
        )
            ->using(AlunoDisciplina::class)
            ->withPivot(
                'situacao_id',
                'nota_final'
            );
    }


    public function areas()
    {
        return $this->morphToMany(
            AreaConhecimento::class,
            'model',
            'model_has_areas',
            'model_id',
            'area_codigo'
        );
    }


    public function notas()
    {
        return $this->hasMany(Nota::class);
    }


    public function periodo()
    {
        return $this->belongsTo(
            Periodo::class,
            'periodo_id'
        );
    }


    public function materialSugeridos()
    {
        return $this->belongsToMany(
            Acervo::class,
            'materiais_sugeridos'
        );
    }


    public function getDisiplinas(
        $page,
        $pageSize,
        $search,
        $sortColumn,
        $sortOrder
    ) {
        $query = self::with('periodo')

            ->when($search, function ($query) use ($search) {
                return $query->where('nome', 'like', '%' . $search . '%');
            })
            ->when($sortColumn, function ($query) use ($sortColumn, $sortOrder) {
                return $query->orderBy(
                    $sortColumn,
                    $sortOrder
                );
            });

        $count = $query->count();
        $value = $query
            ->offset($page * $pageSize)
            ->limit($pageSize)
            ->get();

        return response()->json([
            'success' => true,
            'count' => $count,
            'data' => $value,
        ]);
    }


    public function getDisciplina($id)
    {
        $disciplina = self::where('id', $id)
            ->with('periodo.nivelEscolar')
            ->first();

        if (!$disciplina) {
            return response()->json([
                'success' => false,
                'message' => 'Valor Inválido'
            ], 400);
        }
        return response()->json([
            'success' => true,
            'data' => $disciplina
        ]);
    }
}
