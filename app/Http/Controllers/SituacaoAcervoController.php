<?php

namespace App\Http\Controllers;

use App\Models\AcervoSituacao;
use Illuminate\Http\Request;

class SituacaoAcervoController extends Controller
{
    function __construct(AcervoSituacao $acervoSituacao)
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->acervoSituacao = $acervoSituacao;
    }

    function listSituacao(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', '');

        return $this->acervoSituacao->listSituacao(
            $page,
            $limit,
            $search
        );
    }
}
