<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Autor;

class AutorController extends Controller
{
    public function __construct(Autor $autor)
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->autor = $autor;
    }


    public function getAutors(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', '');

        return  $this->autor->getAutors($page, $limit, $search);
    }


    public function getAutor(Request $request, $id)
    {
        $com_acervos = $request->query('comAcervos', false);
        return $this->autor->getAutorById($id, $com_acervos);
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

        return response()->json(['success' => true, 'data' => $this->autor->createAutor($data)]);
    }


    public function deleteAutor(Request $request, $id)
    {
        $permissionResult = $this->checkPermission('autor.delete');
        if ($permissionResult !== null) {
            return $permissionResult;
        }
        $this->autor->deleteAutor($id);
        return response()->json([
            'success' => true,
            'message' => 'Autor deleted'
        ]);
    }
}
