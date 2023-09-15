<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao'
    ];

    public function pessoasSugeridas()
    {
        return $this->morphToMany(Aluno::class, 'sugeridos');
    }


    public function parametros()
    {
        return $this->morphMany(Parametro::class, 'model');
    }

    public static function getCursos($page, $limit, $search)
    {
        $sugeridos_id = [];


        if (auth()->user()->hasRole('Aluno')) {
            $sugeridos_id = auth()->user()->aluno->getCursosSugeridosId();
        }

        return self::orderBy('nome')
            ->offset($page * $limit)
            ->limit($limit)
            ->when($search, function ($query) use ($search) {
                return $query->where('nome', 'like', '%' . $search . '%')
                    ->orWhere('descricao', 'like', '%' . $search . '%');
            })
            ->whereNotIn('id', $sugeridos_id)
            ->get();
    }
}
