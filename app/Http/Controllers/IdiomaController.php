<?php

namespace App\Http\Controllers;

use App\Models\Idioma;
use Illuminate\Http\Request;

class IdiomaController extends Controller
{
    public function __construct(Idioma $idioma)
    {
        $this->idioma = $idioma;
        $this->middleware('auth:api', ['except' => []]);
    }

    function listIdiomas(Request $request)
    {

        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', '');

        return $this->idioma->listIdiomas(
            $page,
            $limit,
            $search
        );
    }
}
