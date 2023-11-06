<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\models\Aluno;
use App\Models\DisciplinaSituacao;
use App\Models\Professor;

class AlunoController extends Controller
{
    public function __construct(Aluno $aluno)
    {
        $this->middleware(
            'auth:api',
            [
                'except' => []
            ]
        );
        $this->aluno = $aluno;
    }


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

        $cursos = $this->aluno->getCursosSugeridos(
            $page,
            $limit,
            $search,
            $sortColumn,
            $sortOrder
        );

        if ($cursos->count() == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi Encontrado nenhuma Curso Sugerida.'
            ], 401);
        }


        $cursos = $sortOrder == 'asc'
            ? $cursos->sortBy($sortColumn)
            : $cursos->sortByDesc($sortColumn);


        return response()->json([
            'success' => true,
            'data' => $cursos->slice(
                $page * $limit,
                $limit
            )
                ->values(),
            'count' => auth()->user()
                ->aluno
                ->cursosSugeridos
                ->count()
        ], 200);
    }


    public function getAtivExtraSugeridos(Request $request)
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
        $tipo = $request->query('tipo', '');

        $ativExtra = $this->aluno->getAtivExtraSugerido(
            $page,
            $limit,
            $search,
            $sortColumn,
            $sortOrder,
            $tipo
        );

        if ($ativExtra->count() == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi Encontrado nenhuma Atividade Sugerida.'
            ], 401);
        }

        $ativExtra = $sortOrder == 'asc'
            ? $ativExtra->sortBy($sortColumn)
            : $ativExtra->sortByDesc($sortColumn);


        return response()->json([
            'success' => true,
            'data' => $ativExtra
                ->slice(
                    $page * $limit,
                    $limit
                )
                ->values(),
            'count' => $ativExtra
                ->count()
        ], 200);
    }


    public function getNotas(Request $request, $id)
    {
        $classe_id = $request->query('classe_id', null);
        $disciplina_id = $request->query('disciplina_id', null);
        $todas_notas = $request->query('todas_notas', false);

        return $this->aluno->getNotas(
            $id,
            $classe_id,
            $disciplina_id,
            $todas_notas
        );
    }

    public function disaparecerSugerido(Request $request)
    {
        $model_id = $request->query('model_id', null);
        $model_type = $request->query('model_type', null);

        return $this->aluno->disaparecerSugerido(
            $model_id,
            $model_type
        );
    }
}
