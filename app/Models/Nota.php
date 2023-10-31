<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;
    public $timestamps = false;


    protected $fillable = [
        'aluno_id',
        'tipo_avaliacao_id',
        'disciplina_id',
        'nota',
        'classe_id'
    ];


    public function aluno()
    {
        return $this->hasOne(Aluno::class);
    }


    public function tipo()
    {
        return $this->belongsTo(TipoAvaliacao::class, 'tipo_avaliacao_id');
    }


    public function disciplina()
    {
        return $this->belongs(Disciplina::class);
    }


    public static function getAlunoNotasWithinDisciplinas($aluno, $disciplinas)
    {
        return self::where('aluno_id', $aluno->id)
            ->whereIn(
                'disciplina_id',
                $disciplinas
                    ->pluck('id')
                    ->toArray()
            )
            ->get();
    }


    public function getTipoAvaliacao()
    {
        return [
            'success' => true,
            'data' => TipoAvaliacao::getTipos()
        ];
    }
}
