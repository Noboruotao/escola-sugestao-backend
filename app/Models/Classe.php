<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $fillable = [
        'professor_id',
        'disciplina_id',
        'ativo'
    ];


    public function alunos()
    {
        return $this->belongsToMany(Aluno::class)
            ->withPivot(['presenca', 'faltas']);
    }


    public function aulas()
    {
        return $this->hasMany(Aula::class);
    }


    public function professor()
    {
        return $this->belongsTo(Professor::class, 'professor_id');
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class, 'disciplina_id');
    }


    public static function getClassesEnableAtivo($ativo, $page, $pageSize, $search, $sortColumn, $sortOrder)
    {
        $user = auth()->user();
        $query = ($user->hasRole('Aluno'))
            ? $user->aluno->classes()->where('ativo', $ativo)
            : $user->professor->classes()->where('ativo', $ativo);

        if ($search !== '') {
            $query->whereHas('disciplina', function ($sub_query) use ($search) {
                $sub_query->where('nome', 'like', "%$search%");
            });
        }

        $qnt = $query->count();

        $datas = $query->with('disciplina')
            ->orderBy($sortColumn, $sortOrder)
            ->offset($page * $pageSize)
            ->limit($pageSize)
            ->get();


        return response()->json([
            'success' => true,
            'data' => $datas,
            'count' => $qnt
        ]);
    }


    public static function getAlunos($id)
    {
        $classe = self::find($id);

        if (!$classe) {
            return response()->json(['success' => false, 'message' => 'Valor Inválido'], 400);
        }
        $alunos = Pessoa::select(['nome', 'id'])
            ->orderBy('nome')
            ->whereIn('id', $classe->alunos->pluck('id'))
            ->get();
        return response()->json(['success' => true, 'data' => $alunos]);
    }


    public static function getClasseDetail($classe_id)
    {
        return self::with(['disciplina', 'professor.pessoa'])->where('id', $classe_id)->first();
    }
}
