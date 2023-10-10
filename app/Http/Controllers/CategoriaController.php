<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function __construct(Categoria $categoria)
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->categoria = $categoria;
    }


    public function getCategorias(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', null);
        $search = $request->query('search', '');
        return $this->categoria->getCategorias($page, $limit, $search);
    }


    public function createCategoria(Request $request)
    {
        $permissionResult = $this->checkPermission('categoria.create');
        if ($permissionResult !== null) {
            return $permissionResult;
        }
        $data = [
            'categoria' => $request->input('categoria'),
        ];
        return response()->json(['success' => true, 'data' => $this->categoria->createCategoria($data)]);
    }


    public function deleteCategoria(Request $request, $id)
    {
        $permissionResult = $this->checkPermission('catedoria.delete');
        if ($permissionResult !== null) {
            return $permissionResult;
        }
        $this->categoria->deleteCategoria($id);
        return response()->json(['success' => true, 'message' => 'Categoria Deleted']);
    }


    public function getAcervosByCategoria(Request $request, $id)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        return response()->json(['success' => true, 'data' => $this->categoria->getAcervosByCategoria($id, $page, $limit)]);
    }
}
