<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprestimo;

class EmprestimoController extends Controller
{
    public function __construct(Emprestimo $emprestimo)
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->emprestimo = $emprestimo;
    }


    public function createEmprestimo(Request $request)
    {
        $roleResult = $this->checkRole('Bibliotecário');
        if ($roleResult !== null) {
            return $roleResult;
        }
        $acervo_id = $request->input('acervo_id');
        $leitor_id = $request->input('leitor_id');

        $emprestimo = $this->emprestimo->makeEmprestimo($acervo_id, $leitor_id);
        return response()->json(['success' => true, 'data' => $emprestimo]);
    }


    public function makeDevolucao(Request $request)
    {
        $roleResult = $this->checkRole('Bibliotecário');
        if ($roleResult !== null) {
            return $roleResult;
        }
        $emprestimo_id = $request->input('emprestimo_id');
        return response()->json(['success' => true, 'data' => $this->emprestimo->makeDevolucao($emprestimo_id)]);
    }


    public function listEmprestimos(Request $request)
    {
        $roleResult = $this->checkRole('Bibliotecário');
        if ($roleResult !== null) {
            return $roleResult;
        }
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $pendente = $request->query('pendente', false);
        $pendente = $pendente == 'true' ? true : false;
        $search = $request->query('search', '');
        return  $this->emprestimo->getEmprestimos($page, $limit, $search, $pendente);
    }


    public function getEmprestimoDetail(Request $request, $id)
    {
        return $this->emprestimo->getEmprestimoDetail($id);
    }

    public function getUserEmprestimos()
    {
        return $this->emprestimo->getUserEmprestimos();
    }
}
