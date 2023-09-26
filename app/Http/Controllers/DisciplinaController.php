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

        $disciplinas = Disciplina::getDisiplinas($page, $pageSize, $search);

        return response()->json([
            'success' => true,
            'data' => $disciplinas['values'],
            'count' => $disciplinas['count']
        ]);
    }


    public function getDisciplinasOfUser(Request $request)
    {
        $page = $request->query('page', 0);
        $pageSize = $request->query('pageSize', 10);
        $search = $request->query('search', null);

        $user = auth()->user();
        if ($user->hasRole('Aluno')) {
            $situacao = $request->input('situacao');
            $disciplinas = $user->aluno
                ->getDisciplinasBySituacao(
                    $page,
                    $pageSize,
                    $search,
                    $situacao
                );
        } else if ($user->hasRole('Professor')) {
            $disciplinas = $user->professor->getDisciplinas(
                $page,
                $pageSize,
                $search,
                true
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
        if (!auth()->user()->can('situacao_aluno.create')) {
            return response()->json(self::notPermitted());
        }
        $nome = $request->input('nome');
        $nova_situacao = DisciplinaSituacao::createSituacao($nome);
        return response()->json(['success' => true, 'data' => $nova_situacao]);
    }


    public function deleteSituacao(Request $request)
    {
        if (!auth()->user()->can('situacao_aluno.delete')) {
            return response()->json(self::notPermitted());
        }
        $id = $request->input('id');
        if (!DisciplinaSituacao::deleteSituacao($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Não foi possivel deleter esta permissão'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Situação deletada com sucesso'
        ]);
    }


    public function getDisciplina(Request $request, $disciplina_id)
    {
        $resposta = Disciplina::getDisciplina($disciplina_id);
        return response()->json($resposta);
    }


    

}
