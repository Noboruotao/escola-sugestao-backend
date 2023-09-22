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
        return $this->hasOne(ALuno::class);
    }


    public function tipo()
    {
        return $this->hasOne(TipoAvaliacao::class);
    }


    public function disciplina()
    {
        return $this->belongs(Disciplina::class);
    }


    public static function getAlunoNotasWithinDisciplinas($aluno, $disciplinas)
    {
        return self::where('aluno_id', $aluno->id)
            ->whereIn('disciplina_id', $disciplinas->pluck('id')->toArray())
            ->get();
    }
}
