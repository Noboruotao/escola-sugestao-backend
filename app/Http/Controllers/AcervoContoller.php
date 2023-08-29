<?php

namespace App\Http\Controllers;

use App\Models\Acervo;
use App\Models\Autor;
use Illuminate\Http\Request;

class AcervoContoller extends Controller
{
    public function listAcervos(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        return response()->json(['success' => true, 'data' => Acervo::getAcervoList($page, $limit)], 200);
    }


    public function createEmprestimo(Request $request)
    {
        if (!auth()->user()->hasRole('Bibliotecário')) {
            return response()->json(['success' => false, 'data' => 'Usuário Não è Bibliotecário']);
        }
        $bibliotecario_id = $request->input('bibliotecario_id');
        $acervo_id = $request->input('acervo_id');
        $leitor_id = $request->input('leitor_id');

        $emprestimo = Acervo::makeEmprestimo($bibliotecario_id, $acervo_id, $leitor_id);
        return response()->json(['success' => true, 'data' => $emprestimo]);
    }


    public function makeDevolucao(Request $request)
    {
        $emprestimo_id = $request->emprestimo_id;
        return response()->json(['success' => true, 'data' => Acervo::makeDevolucao($emprestimo_id)]);
    }


    public function getAllEmprestimos(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        return response()->json(['success' => true, 'data' => Acervo::getEmprestimos($page, $limit)], 200);
    }


    public function getEmprestimosPendentes(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        return response()->json(['success' => true, 'data' => Acervo::getEmprestimos($page, $limit, true)], 200);
    }
}
