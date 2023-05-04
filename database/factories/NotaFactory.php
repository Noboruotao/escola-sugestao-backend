<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotaFactory extends customFactory
{
    
    public function definition()
    {
        dump('Starting Nota seeding');
        $notas = new NotaFactory();

        $notas->insertNotas();
        // $notas->inserirAlunoArea();
        
    }


    protected function insertNotas()
    {
        $notas = [];
        $aluno_disciplina = [];

        foreach( \App\Models\Aluno::all() as $aluno )
        {
            for($i=1; $i<($aluno->ano->id); $i++)
            {
                $disciplinas = \App\Models\Ano::find($i)->disciplinas;
                foreach($disciplinas as $disciplina)
                {
                    $notaP1 = (($this->faker->biasedNumberBetween($min = 0, $max = 1000, $function = 'sqrt') ) / 100.0);
                    $notaP2 = (($this->faker->biasedNumberBetween($min = 0, $max = 1000, $function = 'sqrt') ) / 100.0);

                    $nota_Final = ($notaP1 * 4 + $notaP2 * 6)/10;
                    
                    $notas[] = [
                        'aluno_id'=>$aluno->id,
                        'tipo_de_avaliacao_id'=> 1,
                        'disciplina_id'=> $disciplina->id,
                        'nota'=> $notaP1,
                        'peso_da_nota'=> 4
                    ];

                    $notas[] = [
                        'aluno_id'=>$aluno->id,
                        'tipo_de_avaliacao_id'=> 2,
                        'disciplina_id'=> $disciplina->id,
                        'nota'=> $notaP2,
                        'peso_da_nota'=> 6
                    ];

                    $aluno_disciplina[] = [
                        'aluno_id'=> $aluno->id,
                        'disciplina_id'=> $disciplina->id,
                        'situacao_id'=>($nota_Final>=5)? 1: 2,
                        'nota_final'=> $nota_Final
                    ];
                }
            }
        }
        $this->insertDatas('aluno_disciplina', $aluno_disciplina);
        $this->insertDatas('notas', $notas);
    }


    protected function inserirAlunoArea()
    {
        $alunos = \App\Models\Aluno::all();

        $aluno_area = [];

        foreach($alunos as $aluno)
        {
            foreach( $aluno->getAlunoArea() as $area)
            {
                $soma = 0;
                $num_disciplina = 0;
                foreach($aluno->disciplinas as $disciplina)
                {
                    if( $disciplina->hasArea($area->nome) )
                    {
                        $soma += $disciplina->pivot->nota_final;
                        $num_disciplina ++;                        
                    }                    
                }

                $aluno_area[] = [
                    'aluno_id'=> $aluno->id,
                    'area_de_conhecimento_id'=> $area->id,
                    'valor_calculado_por_notas'=> ($soma/$num_disciplina)
                ];
            }
            $this->insertDatas('aluno_areas_de_conhecimento', $aluno_area);
        }
    }
}
