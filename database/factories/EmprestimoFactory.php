<?php

namespace Database\Factories;

use App\Models\Emprestimo;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pessoa;
use App\Models\Aluno;

class EmprestimoFactory extends customFactory
{
    public function definition()
    {
        dump('Starting Emprestimo seeding');
        $emprestimos = new EmprestimoFactory();
        
        // $emprestimos->makeEmprestimos();
        // $emprestimos->attributeAcervoValueToAluno();

    }


    protected function makeEmprestimos()
    {
        echo "    start makeEmprestimos()". PHP_EOL;
        $datas = [];

        $pessoas = Aluno::whereBetween('ano_id', [6, 17])->get()->merge(\App\Models\Professor::all());
        $bibliotecarios = Pessoa::getPessoaByRole('Bibliotecário');

        foreach($pessoas as $pessoa)
        {
            foreach(\App\Models\Acervo::inRandomOrder()->limit($this->faker->numberBetween($min = 0, $max = 5))->get() as $acervo)
            {
                $data_de_emprestimo = $this->faker->dateTimeBetween($startDate = '-3 years', $endDate = '-1 week', $timezone = null);
                $datas[] = [
                    'acervo_id'=> $acervo->id,
                    'bibliotecario_id'=> $this->faker->randomElement($bibliotecarios)->id,
                    'leitor_id'=> $pessoa->id,
                    'data_de_emprestimo'=> $data_de_emprestimo,
                    'data_de_devolucao'=> $this->faker->dateTimeBetween($data_de_emprestimo, 'now'),
                    'created_at'=> now(),
                    'updated_at'=> now()
                ];
            }
        }
        $this->insertDatas('emprestimos', $datas);
    }


    protected function getAreasFromAcervos($acervos)
    {
        $areas = collect();
        foreach($acervos as $acervo)
        {
            $areas = $areas->merge(($acervo->areas)->diff($areas));
        }
        return $areas;
    }


    protected function attributeAcervoValueToAluno()
    {
        echo "    start attributeAcervoValueToAluno()". PHP_EOL;

        foreach(Aluno::whereIn('id', Emprestimo::distinct('leitor_id')->pluck('leitor_id'))->get() as $leitor)
        {
            $areas_do_aluno = $leitor->areas;
            $acervos = \App\Models\Acervo::whereIn('id', Emprestimo::where('leitor_id', $leitor->id)->pluck('acervo_id')->toArray())->get();
            foreach($acervos as $acervo)
            {
                foreach($acervo->areas as $area)
                {
                    if ($areas_do_aluno->contains('id', $area->id)) {
                        $area_do_aluno = $areas_do_aluno->firstWhere('id', $area->id);
                        $area_do_aluno->pivot->valor_calculado_pelo_emprestimo_de_acervo += 0.4;
                        $area_do_aluno->pivot->update(['valor_calculado_pelo_emprestimo_de_acervo' => $area_do_aluno->pivot->valor_calculado_pelo_emprestimo_de_acervo]);
                    }else{
                        $this->insertDatas('aluno_areas_de_conhecimento', [[
                                'aluno_id'=> $leitor->id,
                                'areas_de_conhecimento_id'=> $area->id,
                                'valor_calculado_pelo_emprestimo_de_acervo'=> 0.4
                            ]]);
                    }
                }
            }
        }
    }
}
