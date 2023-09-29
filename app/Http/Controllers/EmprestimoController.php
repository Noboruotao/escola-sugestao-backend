<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Acervo;
use App\Models\Emprestimo;

class EmprestimoController extends Controller
{
    public function createEmprestimo(Request $request)
    {
        $roleResult = $this->checkRole('Bibliotecario');
        if ($roleResult !== null) {
            return $roleResult;
        }
        $bibliotecario_id = $request->input('bibliotecario_id');
        $acervo_id = $request->input('acervo_id');
        $leitor_id = $request->input('leitor_id');

        $emprestimo = Emprestimo::makeEmprestimo($bibliotecario_id, $acervo_id, $leitor_id);
        return response()->json(['success' => true, 'data' => $emprestimo]);
    }


    public function makeDevolucao(Request $request)
    {
        $roleResult = $this->checkRole('Bibliotecario');
        if ($roleResult !== null) {
            return $roleResult;
        }
        $emprestimo_id = $request->input('emprestimo_id');
        return response()->json(['success' => true, 'data' => Emprestimo::makeDevolucao($emprestimo_id)]);
    }


    public function listEmprestimos(Request $request)
    {
        $roleResult = $this->checkRole('Bibliotecario');
        if ($roleResult !== null) {
            return $roleResult;
        }
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $pendente = $request->query('pendente', false);
        return response()->json([
            'success' => true,
            'data' => Emprestimo::getEmprestimos($page, $limit, $pendente)
        ], 200);
    }
}
