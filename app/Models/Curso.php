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
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function pessoasSugeridas()
    {
        return $this->morphToMany(Aluno::class, 'sugeridos');
    }


    public function parametros()
    {
        return $this->morphMany(Parametro::class, 'model');
    }

    public function getCursos($page, $limit, $search, $sortColumn, $order)
    {
        $sugeridos_id = [];


        if (auth()->user()->hasRole('Aluno')) {
            $sugeridos_id = auth()->user()->aluno->getCursosSugeridosId();
        }


        $query = self::orderBy($sortColumn, $order)
            ->when($search, function ($query) use ($search) {
                return $query->where('nome', 'like', '%' . $search . '%')
                    ->orWhere('descricao', 'like', '%' . $search . '%');
            })
            ->whereNotIn('id', $sugeridos_id);

        $count = $query->count();
        $values = $query
            ->skip($page * $limit)
            ->take($limit)
            ->get();
        return ['values' => $values, 'count' => $count];
    }
}
