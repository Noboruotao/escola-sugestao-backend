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

        return $resposta = Classe::getClassesEnableAtivo($ativo, $page, $pageSize, $search);
    }


    public function getAlunos(Request $request, $id)
    {
        return Classe::getAlunos($id);
    }


    public function getClasseDetail(Request $request, $id)
    {
        $resposta = Classe::getClasseDetail($id);
        return response()->json(['success' => true, 'data' => $resposta]);
    }
}
