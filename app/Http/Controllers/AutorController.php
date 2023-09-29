<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;

class AutorController extends Controller
{
    public function getAutors(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        return response()->json(['success' => true, 'data' => Autor::getAutors($page, $limit)]);
    }


    public function getAutor(Request $request, $id)
    {
        return response()->json(['success' => true, 'data' => Autor::getAutorById($id)]);
    }


    public function createAutor(Request $request)
    {
        $permissionResult = $this->checkPermission('autor.create');
        if ($permissionResult !== null) {
            return $permissionResult;
        }

        $data = [];
        $data['nome'] = $request->input('nome');
        $data['nacionalidade_id'] = $request->input('nacionalidade_id');
        $data['ano_nascimento'] = $request->input('ano_nascimento');
        $data['ano_falecimento'] = $request->input('ano_falecimento');

        return response()->json(['success' => true, 'data' => Autor::createAutor($data)]);
    }


    public function deleteAutor(Request $request, $id)
    {
        $permissionResult = $this->checkPermission('autor.delete');
        if ($permissionResult !== null) {
            return $permissionResult;
        }
        Autor::deleteAutor($id);
        return response()->json(['success' => true, 'message' => 'Autor deleted']);
    }
}
