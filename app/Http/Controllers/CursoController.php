<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursoController extends Controller
{
    public function __construct(Curso $curso)
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->curso = $curso;
    }


    public function getCursos(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', null);

        $sortColumn = $request->query('sortColumn', 'nome');
        $order = $request->query('order', 'asc');

        $response = $this->curso->getCursos(
            $page,
            $limit,
            $search,
            $sortColumn,
            $order
        );

        return response()->json([
            'success' => true,
            'data' => $response['values'],
            'count' => $response['count']
        ]);
    }


    public function getCurso(Request $request, $id)
    {
        $curso = Curso::find($id);
        return response()->json([
            'success' => true,
            'data' => $curso
        ], 200);
    }
}
