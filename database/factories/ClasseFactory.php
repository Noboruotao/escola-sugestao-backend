<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClasseFactory extends customFactory
{
    public function definition()
    {
        $classe = new ClasseFactory();

        $classe->professorLeciona();
        
    }


    protected function insertClasse()
    {
        
    }


    protected function professorLeciona()
    {
       $professores = \App\Models\Professor::inRandomOrder()->first();
       dump($professores->cursos[0]->areas[0]->nome);
    }
}
