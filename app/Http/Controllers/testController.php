<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use Illuminate\Http\Request;

class testController extends Controller
{
    public function getDatasForTest()
    {
        $professor = Pessoa::role('Professor')->inRandomOrder()->first();

        $classe = $professor->professor->classes()->where('ativo', 0)->inRandomOrder()->first();

        $aluno = $classe->alunos->first();

        return response()->json([
            'professor' => $professor,
            'aluno' => $aluno->pessoa,
            'classe' => $classe->id,
        ]);
    }
}
