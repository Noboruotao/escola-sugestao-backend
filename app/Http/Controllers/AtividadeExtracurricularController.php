<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AtividadeExtra;
use App\Models\AtivExtraTipo;

class AtividadeExtracurricularController extends Controller
{
    public function __construct(AtividadeExtra $atividade_extra, AtivExtraTipo $ativExtra)
    {
        $this->middleware('auth:api', ['except' => []]);
        $this->atividade_extra = $atividade_extra;
        $this->ativExtra = $ativExtra;
    }


    public function getAtivExtras(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', null);
        $sortColumn = $request->query('sortColumn', null);
        $order = $request->query('order', null);
        $tipo = $request->query('tipo', '');

        $ativExtrasList = $this->atividade_extra->getAtivExtras(
            $page,
            $limit,
            $search,
            $sortColumn,
            $order,
            $tipo
        );

        return response()->json([
            'success' => true,
            'data' => $ativExtrasList['data'],
            'count' => $ativExtrasList['count']
        ]);
    }

    public function getAtivExtraDetail(Request $request, $id)
    {
        return $this->atividade_extra->getAtivExtraDetail($id);
    }


    public function getAtivExtraTipo()
    {
        return response()->json([
            'success' => true,
            'data' => $this->ativExtra->get(),
        ], 200);
    }


    public function attributeAtivExtraToAluno(Request $request)
    {
        $aluno_id = $request->input('aluno_id');
        $ativExtra_id = $request->input('ativExtra_id');

        return $this->atividade_extra->attributeAtivExtraToAluno($aluno_id, $ativExtra_id);
    }
}
