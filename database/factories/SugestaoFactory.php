<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SugestaoFactory extends customFactory
{
    public function definition()
    {
        dump('Starting Sugestao seeding');

        $sugetao = new SugestaoFactory();

        $sugetao->sugerirCursos();
        $sugetao->sugerirAtividades();
    }


    protected function sugerirCursos()
    {        
        echo "    start sugerirCursos()". PHP_EOL;

        foreach(\App\Models\Aluno::all() as $aluno)
        {
            \App\Models\Curso::sugerirCursos($aluno);
        }
    }


    protected function sugerirAtividades()
    {        
        echo "    start sugerirAtividades()". PHP_EOL;

        foreach(\App\Models\Aluno::all() as $aluno)
        {
            \App\Models\AtividadesExtracurriculares::sugerirAtividadeExtracurricular($aluno);
        }
    }
}
