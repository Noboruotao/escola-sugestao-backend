<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\models\Aluno;
use App\Models\DisciplinaSituacao;

class AlunoController extends Controller
{
    public function getCursosSugeridos(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', null);

        $user = auth()->user();
        if (!$user->hasRole('Aluno')) {
            return response()->json(['success' => false, 'data' => 'Usuário não é Aluno']);
        }
        $cursos = $user->aluno->cursosSugeridos->slice($page * $limit, $limit);
        return response()->json([
            'success' => true,
            'data' => $cursos,
            'count' => $user->aluno->cursosSugeridos->count()
        ]);
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
            'data' => $user->aluno->getCursosPorSituacao(DisciplinaSituacao::APROVADO),
        ]);
    }
}
