<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Professor;

class ProfessorController extends Controller
{
    public function attributeNota(Request $request)
    {
        $aluno_id = $request->input('aluno_id');
        $classe_id = $request->input('classe_id');
        $tipo_avaliacao_id = $request->input('tipo_avaliacao_id');
        $nota = $request->input('nota');

        $resposta = Professor::attributeNota($aluno_id, $classe_id, $tipo_avaliacao_id, $nota);

        return response()->json($resposta);
    }


    public function makeNotaFinal(Request $request)
    {

        $aluno_id = $request->input('aluno_id');
        $classe_id = $request->input('classe_id');
        $nota_final = $request->input('nota_final');

        $resposta = Professor::makeNotaFinal($aluno_id, $classe_id, $nota_final);

        return response()->json($resposta);
    }
}
