<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'professors';

    protected $fillable = [
        'experiencia_profissional'
    ];


    /**
     * acessar os dados de Pessoa com mesmo id
     */
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id', 'id');
    }


    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'curso_professor');
    }


    public function getCursos()
    {
        return $this->cursos()->pluck('nome');
    }


    public function professorAreas()
    {
        $areasDoCurso = collect([]);
        $cursos = $this->cursos;

        foreach ($cursos as $curso) {
            foreach ($curso->areas as $area) {
                $areasDoCurso->push($area);
            }
        }
        return $areasDoCurso;
    }
}
