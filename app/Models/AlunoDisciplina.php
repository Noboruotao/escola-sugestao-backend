<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunoDisciplina extends Pivot
{
    use HasFactory;

    protected $table = 'aluno_Disciplina';

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }


    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }


    public function situacao()
    {
        return $this->belongsTo(SituacaoDaDisciplina::class, 'situacao_id');
    }
}
