<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bolsa extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['nome', 'valor'];


    public function getValorMensalidade($id, $valor_bruto = 1500)
    {
        return $valor_bruto - \Illuminate\Support\Facades\DB::table('alunos')
            ->where('alunos.id', $id)
            ->join('aluno_bolsa', 'aluno_bolsa.aluno_id', '=', 'alunos.id')
            ->join('bolsas', 'aluno_bolsa.bolsa_id', '=', 'bolsas.id')
            ->sum('bolsas.valor');
    }
}
