<?php

namespace App\Http\Controllers;

use App\Models\AcervoEstado;
use Illuminate\Http\Request;

class EstadoAcervoController extends Controller
{
    function __construct(AcervoEstado $acervoEstado)
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->acervoEstado = $acervoEstado;
    }

    function listEstado(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', '');

        return $this->acervoEstado->listEstado($page, $limit, $search);
    }
}
