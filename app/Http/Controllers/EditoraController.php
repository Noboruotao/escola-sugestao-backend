<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Editora;

class EditoraController extends Controller
{
    public function __construct(Editora $editora)
    {
        $this->editora = $editora;
        $this->middleware('auth:api', ['except' => []]);
    }

    function listEditora(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', '');


        return $this->editora->listEditoras($page, $limit, $search);
    }
}
