<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AtividadeExtra;

class AtividadeExtracurricularController extends Controller
{
    public function getAtivExtras(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', null);


        return response()->json(['success' => true, 'data' => AtividadeExtra::getAtivExtra($page, $limit, $search)]);
    }
}
