<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AtividadeExtra;
use App\Models\AtivExtraTipo;

class AtividadeExtracurricularController extends Controller
{
    public function __construct(AtividadeExtra $atividade_extra, AtivExtraTipo $ativExtra_tipo)
    {
        $this->middleware(
            'auth:api',
            [
                'except' => []
            ]
        );
        $this->atividade_extra = $atividade_extra;
        $this->ativExtra_tipo = $ativExtra_tipo;
    }


    public function getAtivExtras(Request $request)
    {
        $page = $request->query('page', 0);
        $limit = $request->query('limit', 10);
        $search = $request->query('search', null);
        $sortColumn = $request->query('sortColumn', null);
        $order = $request->query('order', null);
        $tipo = $request->query('tipo', '');

        return $this->atividade_extra
            ->getAtivExtras(
                $page,
                $limit,
                $search,
                $sortColumn,
                $order,
                $tipo
            );
    }

    public function getAtivExtraDetail(
        Request $request,
        $id
    ) {
        return $this->atividade_extra
            ->getAtivExtraDetail($id);
    }


    public function getAtivExtraTipo()
    {
        return $this->ativExtra_tipo
            ->getAtivExtraTipos();
    }


    public function attributeAtivExtraToAluno(Request $request)
    {
        $aluno_id = $request->input('aluno_id');
        $ativExtra_id = $request->input('ativExtra_id');

        return $this->atividade_extra
            ->attributeAtivExtraToAluno(
                $aluno_id,
                $ativExtra_id
            );
    }

    public function getAlunos(Request $request)
    {
        $id = $request->query('id', null);
        $page = $request->query('page', 0);
        $pageSize = $request->query('pageSize', 10);

        return $this->atividade_extra->getAlunos(
            $id,
            $page,
            $pageSize
        );
    }


    public function removeAlunoFromAtivExtra(Request $request)
    {
        $aluno_id = $request->input('aluno_id');
        $ativExtra_id = $request->input('ativExtra_id');

        return $this->atividade_extra->removeAlunoFromAtivExtra(
            $aluno_id,
            $ativExtra_id
        );
    }
}
