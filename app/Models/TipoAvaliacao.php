<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAvaliacao extends Model
{
    use HasFactory;

    public const P1 = 1;
    public const P2 = 2;
    public const TRABALHO = 3;
    public const P_SUB = 4;

    protected $table = 'tipos_avaliacoes';
    protected $fillable = ['nome'];


    public static function getTipoAvaliacao(
        $aluno_id = null,
        $classe_id = null
    ) {
        if ($aluno_id && $classe_id) {
            $tipos = self::whereNotIn(
                'id',
                self::getTipoAvaliacaoUsados(
                    $aluno_id,
                    $classe_id
                )
            )->get();
        } else {
            $tipos = self::get();
        }

        return response()->json([
            'success' => true,
            'data' => $tipos
        ]);
    }


    public static function getTipoAvaliacaoUsados(
        $aluno_id,
        $classe_id
    ) {
        return  Nota::where('aluno_id', $aluno_id)
            ->where('classe_id', $classe_id)
            ->where('tipo_avaliacao_id', '!=', 3)
            ->pluck('tipo_avaliacao_id')
            ->unique();
    }
}
