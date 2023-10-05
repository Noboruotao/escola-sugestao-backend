<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;

class ClasseController extends Controller
{
    public function __construct(Classe $classe)
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->classe = $classe;
    }


    public function getClasses(Request $request)
    {
        $ativo = $request->query('ativo', 1);
        $page = $request->query('page', 0);
        $pageSize = $request->query('pageSize', 10);
        $search = $request->query('search', '');
        $sortColumn = $request->query('sortColumn', 'ano');
        $sortOrder = $request->query('sortOrder', 'asc');

        return $resposta = $this->classe->getClassesEnableAtivo(
            $ativo,
            $page,
            $pageSize,
            $search,
            $sortColumn,
            $sortOrder
        );
    }


    public function getAlunos(Request $request, $id)
    {
        return $this->classe->getAlunos($id);
    }


    public function getClasseDetail(Request $request, $id)
    {
        return $this->classe->getClasseDetail($id);
    }
}
