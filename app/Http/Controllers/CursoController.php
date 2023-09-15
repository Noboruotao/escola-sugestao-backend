<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;

class CursoController extends Controller
{
    public function getCursos(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', null);


        return response()->json([
            'success' => true,
            'data' => Curso::getCursos($page, $limit, $search),
            'count' => Curso::count()
        ]);
    }
}
