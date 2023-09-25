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


    private static function isAluno()
    {
        if (!auth()->user()->hasRole('Aluno')) {
            return ['success' => false, 'data' => 'Usuário não é Aluno'];
        }

        return ['success' => true];
    }

    public function getClasseNotas(Request $request)
    {
        $classe_id = $request->query('classe_id', null);
        if ($classe_id == null) {
            return response()->json(['success' => false, 'message' => 'Valor Inválido.']);
        }

        $resposta = auth()->user()->aluno->getClasseNotas($classe_id);

        return response()->json($resposta);
    }

    public function getDisciplinaNotas(Request $request, $id)
    {
        $todas_notas = $request->query('todas_notas', false);

        $data = Aluno::getDisciplinaNotas($id, $todas_notas);
        return response()->json($data);
    }
}
