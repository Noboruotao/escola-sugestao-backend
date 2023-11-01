<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsavel extends Model
{
    use HasFactory;

    protected $table = 'responsavel';
    protected $fillable = ['responsavel_id', 'aluno_id'];
    public $timestamps = false;


    public function pessoa()
    {
        return $this->belongsTo(Pessoa::class, 'responsavel_id', 'id');
    }


    public static function attributeAlunoResponsavel($alunoId, $responsavelId)
    {

        $aluno = Aluno::find($alunoId);
        $responsavel = Pessoa::find($responsavelId);

        if (!$aluno || !$responsavel) {
            return response()->json([
                'success' => false,
                'message' => 'Aluno ou Responsavel não Encontrado'
            ], 404);
        }

        $responsavel = new Responsavel();
        $responsavel->responsavel_id = $responsavelId;
        $responsavel->aluno_id = $alunoId;
        $responsavel->save();

        return response()->json([
            'success' => true,
            'message' => 'Responsavel Cadastrado com Sucesso'
        ], 200);
    }
}
