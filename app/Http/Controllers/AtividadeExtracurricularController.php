<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AtividadeExtra;

class AtividadeExtracurricularController extends Controller
{
    public function __construct(AtividadeExtra $atividade_extra)
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->atividade_extra = $atividade_extra;
    }


    public function getAtivExtras(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', null);


        return response()->json(['success' => true, 'data' => $this->atividade_extra->getAtivExtra($page, $limit, $search)]);
    }
}
