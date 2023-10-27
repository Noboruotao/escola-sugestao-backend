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

        $bibliotecario = Pessoa::role('Bibliotecario')->inRandomOrder()->first();

        $secretaria = Pessoa::role('Secretaria')->inRandomOrder()->first();

        return response()->json([
            'professor' => $professor->only(['id', 'nome', 'email']),
            'aluno' => $aluno->pessoa->only(['id', 'nome', 'email']),
            'classe' => $classe->id,
            'bibliotecario' => $bibliotecario->only(['id', 'nome', 'email']),
            'secretaria' => $secretaria->only(['id', 'nome', 'email']),
        ]);
    }
}
