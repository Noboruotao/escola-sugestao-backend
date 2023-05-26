<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Collection;
use \App\Models\Aluno;

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
        echo "    start sugerirCursos()" . PHP_EOL;
        Aluno::orderBy('id')->chunk(500, function (Collection $alunos) {
            foreach ($alunos as $aluno) {
                \App\Models\Curso::sugerirCursos($aluno);
            }
        });
    }


    protected function sugerirAtividades()
    {
        echo "    start sugerirAtividades()" . PHP_EOL;

        Aluno::orderBy('id')->chunk(500, function (Collection $alunos) {
            foreach ($alunos as $aluno) {
                \App\Models\AtividadesExtracurriculares::sugerirAtividadeExtracurricular($aluno);
            }
        });
    }
}
