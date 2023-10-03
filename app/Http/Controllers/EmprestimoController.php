<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprestimo;

class EmprestimoController extends Controller
{
    public function __construct(Acervo $acervo, Emprestimo $emprestimo)
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->acervo = $acervo;
        $this->emprestimo = $emprestimo;
    }


    public function createEmprestimo(Request $request)
    {
        $roleResult = $this->checkRole('Bibliotecario');
        if ($roleResult !== null) {
            return $roleResult;
        }
        $bibliotecario_id = $request->input('bibliotecario_id');
        $acervo_id = $request->input('acervo_id');
        $leitor_id = $request->input('leitor_id');

        $emprestimo = $this->emprestimo->makeEmprestimo($bibliotecario_id, $acervo_id, $leitor_id);
        return response()->json(['success' => true, 'data' => $emprestimo]);
    }


    public function makeDevolucao(Request $request)
    {
        $roleResult = $this->checkRole('Bibliotecario');
        if ($roleResult !== null) {
            return $roleResult;
        }
        $emprestimo_id = $request->input('emprestimo_id');
        return response()->json(['success' => true, 'data' => $this->emprestimo->makeDevolucao($emprestimo_id)]);
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
            'data' => $this->emprestimo->getEmprestimos($page, $limit, $pendente)
        ], 200);
    }
}
