<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use App\Models\DisciplinaSituacao;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    public function __construct(Disciplina $disciplina, DisciplinaSituacao $disciplina_situacao)
    {
        $this->middleware(
            'auth:api',
            [
                'except' => []
            ]
        );
        $this->disciplina = $disciplina;
        $this->disciplina_situacao = $disciplina_situacao;
    }


    public function getDisciplinas(Request $request)
    {
        $page = $request->query('page', 0);
        $pageSize = $request->query('pageSize', 10);
        $search = $request->query('search', null);
        $sortColumn = $request->query('sortColumn', null);
        $sortOrder = $request->query('sortOrder', 'asc');

        return $this->disciplina
            ->getDisiplinas(
                $page,
                $pageSize,
                $search,
                $sortColumn,
                $sortOrder
            );
    }


    public function getDisciplinasOfUser(Request $request)
    {
        $roleResult = $this->checkRole([
            'Aluno',
            'Professor'
        ]);
        if ($roleResult !== null) {
            return $roleResult;
        }

        $page = $request->query('page', 0);
        $pageSize = $request->query('pageSize', 10);
        $search = $request->query('search', null);
        $situacao = $request->query('situacao', 1);
        $sortColumn = $request->query('sortColumn', null);
        $sortOrder = $request->query('sortOrder', 'asc');

        $user = auth()->user();

        if ($user->hasRole('Aluno')) {
            return $user->aluno
                ->getDisciplinasBySituacao(
                    $page,
                    $pageSize,
                    $search,
                    $situacao,
                    $sortColumn,
                    $sortOrder
                );
        } else if ($user->hasRole('Professor')) {
            return $user->professor
                ->getDisciplinas(
                    $page,
                    $pageSize,
                    $search,
                    $situacao,
                    $sortColumn,
                    $sortOrder
                );
        }
    }


    public function getSituacoesDisciplina()
    {
        return $this->disciplina_situacao->getSituacoesDisciplina();
    }


    public function createSituacao(Request $request)
    {
        $permissionResult = $this->checkPermission('situacao_aluno.create');
        if ($permissionResult !== null) {
            return $permissionResult;
        }
        $nome = $request->input('nome');
        return  $this->disciplina_situacao
            ->createSituacao($nome);
    }


    public function deleteSituacao(Request $request)
    {
        $permissionResult = $this->checkPermission('situacao_aluno.delete');
        if ($permissionResult !== null) {
            return $permissionResult;
        }
        $id = $request->input('id');
        return $this->disciplina_situacao
            ->deleteSituacao($id);
    }


    public function getDisciplina(Request $request, $disciplina_id)
    {
        return $this->disciplina
            ->getDisciplina($disciplina_id);
    }
}
