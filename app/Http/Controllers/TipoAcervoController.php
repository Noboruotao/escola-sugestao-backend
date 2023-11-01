<?php

namespace App\Http\Controllers;

use App\Models\AcervoTipo;
use Illuminate\Http\Request;

class TipoAcervoController extends Controller
{
    function __construct(AcervoTipo $acervoTipo)
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->acervoTipo = $acervoTipo;
    }

    function listAcervoTipo(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', '');

        return $this->acervoTipo->listAcervoTipos(
            $page,
            $limit,
            $search
        );
    }
}
