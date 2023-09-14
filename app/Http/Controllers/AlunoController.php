<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\models\Aluno;
use App\Models\DisciplinaSituacao;

class AlunoController extends Controller
{
    public function getCursosSugeridos()
    {
        $user = auth()->user();
        if (!$user->hasRole('Aluno')) {
            return response()->json(['success' => false, 'data' => 'Usuário não é Aluno']);
        }
        $cursos = $user->aluno->cursosSugeridos;
        return response()->json(['success' => true, 'data' => $cursos]);
    }


    public function getAtivExtraSugeridos()
    {
        $user = auth()->user();
        if (!$user->hasRole('Aluno')) {
            return response()->json(['success' => false, 'data' => 'Usuário não é Aluno']);
        }
        $ativExtra = $user->aluno->ativExtraSugeridos;
        return response()->json(['success' => true, 'data' => $ativExtra]);
    }


    public function getDisciplinasEmAndamento()
    {
        $user = auth()->user();
        if (!$user->hasRole('Aluno')) {
            return response()->json(['success' => false, 'data' => 'Usuário não é Aluno']);
        }

        return response()->json([
            'success' => true,
            'data' => $user->aluno->getCursosPorSituacao(DisciplinaSituacao::Aprovado),
        ]);
    }
}
