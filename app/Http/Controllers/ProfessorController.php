<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Professor;

class ProfessorController extends Controller
{


    // public function getClasses(Request $request)
    // {
    //     $ativo = $request->query('ativo', 1);
    //     $page = $request->query('page', 0);
    //     $pageSize = $request->query('pageSize', 10);
    //     $search = $request->query('search', '');

    //     $resposta = auth()->user()->professor->getClassesEnableAtivo($ativo, $page, $pageSize, $search);


    //     return response()->json($resposta, 200);
    // }


    public function attributeNota(Request $request)
    {
        $permissionResult = $this->checkPermission('nota.create');
        if ($permissionResult !== null) {
            return $permissionResult;
        }
        $aluno_id = $request->input('aluno_id');
        $classe_id = $request->input('classe_id');
        $tipo_avaliacao_id = $request->input('tipo_avaliacao_id');
        $nota = $request->input('nota');

        $resposta = Professor::attributeNota($aluno_id, $classe_id, $tipo_avaliacao_id, $nota);

        return response()->json($resposta);
    }


    public function makeNotaFinal(Request $request)
    {
        $permissionResult = $this->checkPermission('nota.create');
        if ($permissionResult !== null) {
            return $permissionResult;
        }
        $aluno_id = $request->input('aluno_id');
        $classe_id = $request->input('classe_id');
        $nota_final = $request->input('nota_final');

        return Professor::makeNotaFinal($aluno_id, $classe_id, $nota_final);

        return response()->json($resposta);
    }


    public function getAlunosClasse(Request $request)
    {
        $classe_id = $request->query('classe_id', null);

        if (!$classe_id) {
            return response()->json(['success' => false, 'message' => 'Valor Inválido']);
        }

        $resposta = auth()->user()->professor->getAlunosClasse($classe_id);

        return response()->json($resposta);
    }
}
