<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function getCategorias(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        return response()->json(['success' => true, 'data' => Categoria::getCategorias($page, $limit)]);
    }


    public function createCategoria(Request $request)
    {
        $data = [
            'categoria' => $request->input('categoria'),
        ];
        return response()->json(['success' => true, 'data' => Categoria::createCategoria($data)]);
    }


    public function deleteCategoria(Request $request, $id)
    {
        Categoria::deleteCategoria($id);
        return response()->json(['success' => true, 'message' => 'Categoria Deleted']);
    }


    public function getAcervosByCategoria(Request $request, $id)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        return response()->json(['success' => true, 'data' => Categoria::getAcervosByCategoria($id, $page, $limit)]);
    }
}
