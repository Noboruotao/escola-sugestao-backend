<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'experiencia_profissional'
    ];

    public function classes()
    {
        return $this->hasMany(Classe::class, 'professor_id');
    }


    public function disciplinas($active = true)
    {
        return $this->classes->where('ativo', $active)->map(function ($class) {
            return $class->disciplina;
        });
    }


    public function getDisciplinas(
        $page,
        $pageSize,
        $search,
        $active = true
    ) {
        $query = $this->classes->where('ativo', $active)->map(function ($class) {
            return $class->disciplina;
        });

        return [
            'values' => $query->slice($page * $pageSize, $pageSize),
            'count' => $query->count()
        ];
    }
}
