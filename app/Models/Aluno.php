<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;
    public $timestamps = false;


    /**
     * acessar os dados de Pessoa com mesmo id
     */
    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'id', 'id');
    }


    public function getValorMensalidade($id, $valor_bruto=1500)
    {
        return $valor_bruto - \Illuminate\Support\Facades\DB::table('alunos')
        ->where('alunos.id', $id)
        ->join('alunos_bolsas', 'alunos_bolsas.aluno_id', '=', 'alunos.id')
        ->join('bolsas', 'alunos_bolsas.bolsa_id', '=', 'bolsas.id')
        ->sum('bolsas.valor');
    }
}
