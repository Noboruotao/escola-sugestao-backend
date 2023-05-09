<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

class EmprestimoFactory extends Factory
{
    public function definition()
    {
        $emprestimos = new EmprestimoFactory();
        
        $emprestimos->makeEmprestimos();
    }


    protected function makeEmprestimos()
    {
        $datas = [];

        $pessoas = \App\Models\Aluno::whereBetween('ano_id', [6, 17])->get()->merge(\App\Models\Professor::all());
        $bibliotecarios = \App\Models\Pessoa::getPessoaByRole('Bibliotecário');
        dump($bibliotecarios->count());

        foreach($pessoas as $pessoa)
        {
            foreach(\App\Models\Acervo::inRandomOrder()->limit($this->faker->numberBetween($min = 0, $max = 20))->get() as $acervo)
            {
                $data_de_emprestimo = $this->faker->dateTimeBetween((string)($this->getIdade($pessoa->data_de_nascimento)-3).'year', '1week');
                $datas[] = [
                    'acervo_id'=> $acervo->id,
                    'bibliotecario'=> $this->faker->randomElement($bibliotecarios)->id,
                    'leitor_id'=> $pessoa->id,
                    'data_de_emprestimo'=> $data_de_emprestimo,
                    'data_de_devolucao'=> $this->faker->dateTimeBetween($data_de_emprestimo, 'now')
                ];
            }
        }
    }
}
