<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acervo;
use App\Models\Emprestimo;

class EmprestimoController extends Controller
{
    public function createEmprestimo(Request $request)
    {
        // if (!auth()->user()->hasRole('Bibliotecário')) {
        //     return response()->json(['success' => false, 'data' => 'Usuário Não è Bibliotecário']);
        // }
        $bibliotecario_id = $request->input('bibliotecario_id');
        $acervo_id = $request->input('acervo_id');
        $leitor_id = $request->input('leitor_id');

        $emprestimo = Emprestimo::makeEmprestimo($bibliotecario_id, $acervo_id, $leitor_id);
        return response()->json(['success' => true, 'data' => $emprestimo]);
    }


    public function makeDevolucao(Request $request)
    {
        $emprestimo_id = $request->emprestimo_id;
        return response()->json(['success' => true, 'data' => Emprestimo::makeDevolucao($emprestimo_id)]);
    }


    public function getAllEmprestimos(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        return response()->json(['success' => true, 'data' => Emprestimo::getEmprestimos($page, $limit)], 200);
    }


    public function getEmprestimosPendentes(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        return response()->json(['success' => true, 'data' => Emprestimo::getEmprestimos($page, $limit, true)], 200);
    }
}
