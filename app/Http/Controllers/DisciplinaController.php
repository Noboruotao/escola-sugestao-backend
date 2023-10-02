<?php

namespace App\Http\Controllers;

use App\Models\Disciplina;
use App\Models\DisciplinaSituacao;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
{
    public function getDisciplinas(Request $request)
    {
        $page = $request->query('page', 0);
        $pageSize = $request->query('pageSize', 10);
        $search = $request->query('search', null);
        $sortColumn = $request->query('sortColumn', null);
        $sortOrder = $request->query('sortOrder', 'asc');

        $disciplinas = Disciplina::getDisiplinas($page, $pageSize, $search, $sortColumn, $sortOrder);

        return response()->json([
            'success' => true,
            'data' => $disciplinas['values'],
            'count' => $disciplinas['count']
        ]);
    }


    public function getDisciplinasOfUser(Request $request)
    {
        $roleResult = $this->checkRole(['Aluno', 'Professor']);
        if ($roleResult !== null) {
            return $roleResult;
        }
        $page = $request->query('page', 0);
        $pageSize = $request->query('pageSize', 10);
        $search = $request->query('search', null);
        $situacao = $request->input('situacao');

        $sortColumn = $request->query('sortColumn', null);
        $sortOrder = $request->query('sortOrder', 'asc');

        $user = auth()->user();
        if ($user->hasRole('Aluno')) {
            $disciplinas = $user->aluno
                ->getDisciplinasBySituacao(
                    $page,
                    $pageSize,
                    $search,
                    $situacao,
                    $sortColumn,
                    $sortOrder
                );
        } else if ($user->hasRole('Professor')) {
            $disciplinas = $user->professor->getDisciplinas(
                $page,
                $pageSize,
                $search,
                $situacao,
                $sortColumn,
                $sortOrder
            );
        }
        return response()->json([
            'success' => true,
            'data' => $disciplinas['values'],
            'count' => $disciplinas['count']
        ]);
    }


    public function getSituacoesDisciplina()
    {
        $situacoes = DisciplinaSituacao::getSituacoesDisciplina();
        return response()->json(['success' => true, 'data' => $situacoes]);
    }


    public function createSituacao(Request $request)
    {
        $permissionResult = $this->checkPermission('situacao_aluno.create');
        if ($permissionResult !== null) {
            return $permissionResult;
        }
        $nome = $request->input('nome');
        $nova_situacao = DisciplinaSituacao::createSituacao($nome);
        return response()->json(['success' => true, 'data' => $nova_situacao]);
    }


    public function deleteSituacao(Request $request)
    {
        $permissionResult = $this->checkPermission('situacao_aluno.delete');
        if ($permissionResult !== null) {
            return $permissionResult;
        }
        $id = $request->input('id');
        if (!DisciplinaSituacao::deleteSituacao($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possivel deleter esta permissão'
            ], 401);
        }
        return response()->json([
            'success' => true,
            'message' => 'Situação deletada com sucesso'
        ]);
    }


    public function getDisciplina(Request $request, $disciplina_id)
    {
        return Disciplina::getDisciplina($disciplina_id);
    }
}
