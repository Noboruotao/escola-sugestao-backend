<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;

class ClasseController extends Controller
{
    public function getClasses(Request $request)
    {
        $ativo = $request->query('ativo', 1);
        $page = $request->query('page', 0);
        $pageSize = $request->query('pageSize', 10);
        $search = $request->query('search', '');

        $resposta = Classe::getClassesEnableAtivo($ativo, $page, $pageSize, $search);


        return response()->json($resposta, 200);
    }


    public function getAlunos(Request $request, $id)
    {
        $resposta = Classe::getAlunos($id);

        return response()->json($resposta);
    }
}
