<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Professor;
use App\Models\TipoAvaliacao;

class ProfessorController extends Controller
{
    public function __construct(Professor $professor, TipoAvaliacao $tipoAvaliacao)
    {
        $this->middleware(
            'auth:api',
            [
                'except' => []
            ]
        );
        $this->professor = $professor;
        $this->tipoAvaliacao = $tipoAvaliacao;
    }


    public function attributeNota(Request $request)
    {
        $permissionResult = $this->checkPermission('notas.create');
        if ($permissionResult !== null) {
            return $permissionResult;
        }

        $aluno_id = $request->input('aluno_id');
        $classe_id = $request->input('classe_id');
        $tipo_avaliacao_id = $request->input('tipo_avaliacao_id');
        $nota = $request->input('nota');

        $resposta = $this->professor
            ->attributeNota(
                $aluno_id,
                $classe_id,
                $tipo_avaliacao_id,
                $nota
            );

        return response()->json($resposta);
    }


    public function makeNotaFinal(Request $request)
    {
        $permissionResult = $this->checkPermission('notas.create');
        if ($permissionResult !== null) {
            return $permissionResult;
        }

        $aluno_id = $request->input('aluno_id');
        $classe_id = $request->input('classe_id');
        $nota_final = $request->input('nota_final');

        return $this->professor->makeNotaFinal(
            $aluno_id,
            $classe_id,
            $nota_final
        );

        return response()->json($resposta);
    }


    public function getAlunosClasse(Request $request)
    {
        $classe_id = $request->query('classe_id', null);

        if (!$classe_id) {
            return response()->json([
                'success' => false,
                'message' => 'Valor Inválido'
            ]);
        }

        $resposta = auth()->user()
            ->professor
            ->getAlunosClasse($classe_id);

        return response()->json($resposta);
    }


    public function getTipoAvaliacao(Request $request)
    {
        $permissionResult = $this->checkRole('Professor');
        if ($permissionResult !== null) {
            return $permissionResult;
        }

        $aluno_id = $request->query('aluno_id', null);
        $classe_id = $request->query('classe_id', null);

        return $this->tipoAvaliacao->getTipoAvaliacao($aluno_id, $classe_id);
    }
}
