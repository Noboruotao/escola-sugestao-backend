<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotaFactory extends customFactory
{
    
    public function definition()
    {
        $notas = new NotaFactory();

        $notas->insertNotas();
        
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
                    $notaP1 = $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10);
                    $notaP2 = $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 10);

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
                        'situacao_id'=>($nota_Final>5)? 1: 2,
                        'nota_final'=> $nota_Final
                    ];

                }
            }
        }
        $this->insertDatas('aluno_disciplina', $aluno_disciplina);
        $this->insertDatas('notas', $notas);
    }
}
