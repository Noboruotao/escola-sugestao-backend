<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\models\Aluno;
use App\Models\DisciplinaSituacao;
use App\Models\Professor;

class AlunoController extends Controller
{
    public function getCursosSugeridos(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', null);

        $notAlunoResponse = self::isAluno();
        if (!$notAlunoResponse['success']) {
            return response()->json($notAlunoResponse);
        }

        $user = auth()->user();

        $cursos = $user->aluno->cursosSugeridos
            ->slice($page * $limit, $limit)
            ->when($search, function ($query) use ($search) {
                return $query->filter(function ($curso) use ($search) {
                    return stripos($curso['nome'], $search) !== false ||
                        stripos($curso['descricao'], $search) !== false;
                });
            });


        return response()->json([
            'success' => true,
            'data' => $cursos,
            'count' => $user->aluno->cursosSugeridos->count()
        ]);
    }


    public function getAtivExtraSugeridos()
    {
        $user = auth()->user();

        $notAlunoResponse = self::isAluno();
        if (!$notAlunoResponse['success']) {
            return response()->json($notAlunoResponse);
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


    private static function isAluno()
    {
        if (!auth()->user()->hasRole('Aluno')) {
            return ['success' => false, 'data' => 'Usuário não é Aluno'];
        }

        return ['success' => true];
    }


    
}
