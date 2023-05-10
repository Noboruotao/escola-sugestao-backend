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
        
        $emprestimos->makeEmprestimos();
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
            foreach(\App\Models\Acervo::inRandomOrder()->limit($this->faker->numberBetween($min = 0, $max = 20))->get() as $acervo)
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
            $acervos_do_aluno = \App\Models\Acervo::whereIn('id', Emprestimo::where('leitor_id', $leitor->id)->pluck('acervo_id')->toArray())->get();
            $areas_acervo = $this->getAreasFromAcervos($acervos_do_aluno);
            $areas_aluno = $leitor->areasDeConhecimento;

            foreach($areas_acervo as $area)
            {
                if($areas_aluno->where('nome', $area->nome))
                {
                    $valor_acervo = $areas_aluno->where('nome', $area->nome);
                    dump($valor_acervo);
                    $valor_acervo->pivot->valor_calculado_pelo_emprestimo_de_acervo += 0.4;
                    $valor_acervo->save();
                }else{
                    $this->insertDatas('aluno_areas_de_conhecimento', [[
                        'aluno_id'=> $leitor->id,
                        'areas_de_conhecimento_id'=>$area->id,
                        'valor_calculado_pelo_emprestimo_de_acervo'=> 0.4
                    ]]);
                }
            
            }

           
                    
        }
    }

}
