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

        $roleResult = $this->checkRole('Aluno');
        if ($roleResult !== null) {
            return $roleResult;
        }

        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', null);
        $sortColumn = $request->query('sortColumn', null);
        $sortOrder = $request->query('sortOrder', null);

        $user = auth()->user();
        $cursos = $user->aluno->cursosSugeridos
            ->when($search, function ($query) use ($search) {
                return $query->filter(function ($curso) use ($search) {
                    return stripos($curso['nome'], $search) !== false ||
                        stripos($curso['descricao'], $search) !== false;
                });
            });

        $cursos = $sortOrder == 'asc'
            ? $cursos->sortBy($sortColumn)
            : $cursos->sortByDesc($sortColumn);


        return response()->json([
            'success' => true,
            'data' => $cursos->slice($page * $limit, $limit)->values(),
            'count' => $user->aluno->cursosSugeridos->count()
        ], 200);
    }


    public function getAtivExtraSugeridos()
    {
        $roleResult = $this->checkRole('Aluno');
        if ($roleResult !== null) {
            return $roleResult;
        }

        $user = auth()->user();
        $ativExtra = $user->aluno->ativExtraSugeridos;
        return response()->json(['success' => true, 'data' => $ativExtra]);
    }





    public function getNotas(Request $request, $id)
    {
        $classe_id = $request->query('classe_id', null);

        $disciplina_id = $request->query('disciplina_id', null);
        $todas_notas = $request->query('todas_notas', false);

        $resposta = Aluno::getNotas($id, $classe_id, $disciplina_id, $todas_notas);

        return $resposta;
    }

    // public function getClasseNotas(Request $request)
    // {
    //     $classe_id = $request->query('classe_id', null);
    //     if ($classe_id == null) {
    //         return response()->json(['success' => false, 'message' => 'Valor Inválido.']);
    //     }

    //     $resposta = auth()->user()->aluno->getClasseNotas($classe_id);

    //     return response()->json($resposta);
    // }

    // public function getDisciplinaNotas(Request $request, $id)
    // {
    //     $disciplina_id = $request->query('disciplina_id', null);
    //     $todas_notas = $request->query('todas_notas', false);

    //     $data = Aluno::getDisciplinaNotas($id, $disciplina_id, $todas_notas);
    //     return response()->json($data);
    // }
}
