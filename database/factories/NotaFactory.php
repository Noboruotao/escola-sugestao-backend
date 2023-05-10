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
        $notas->inserirAlunoArea();
    }


    protected function gerarRandomNota()
    {
        return ($this->faker->biasedNumberBetween($min = 0, $max = 1000, $function = 'sqrt', $bias = 4.0) / 100.0);
    }


    protected function insertNotas()
    {
        echo "    start insertNotas()". PHP_EOL;
        $notas = [];
        $aluno_disciplina = [];

        foreach( \App\Models\Aluno::all() as $aluno )
        {
            for($i=1; $i<($aluno->ano->id); $i++)
            {
                $disciplinas = \App\Models\Ano::find($i)->disciplinas;
                foreach($disciplinas as $disciplina)
                {
                    $notaP1 = $this->gerarRandomNota();
                    $notaP2 = $this->gerarRandomNota();

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

                    if( (($notaP1 * 4 + $notaP2 * 6)/10)<5 )
                    {
                        if( $notaP1 < $notaP2 )
                        {
                            $notaSub = $this->gerarRandomNota();
                            $notaP1 = ($notaSub>$notaP1)?$notaSub: $notaP1;
                            $notas[] = [
                                'aluno_id'=>$aluno->id,
                                'tipo_de_avaliacao_id'=> 4,
                                'disciplina_id'=> $disciplina->id,
                                'nota'=> $notaP1,
                                'peso_da_nota'=> 4
                            ];

                        }else{

                            $notaSub = $this->gerarRandomNota();
                            $notaP2 = ($notaSub>$notaP2)?$notaSub: $notaP2;
                            $notas[] = [
                                'aluno_id'=>$aluno->id,
                                'tipo_de_avaliacao_id'=> 4,
                                'disciplina_id'=> $disciplina->id,
                                'nota'=> $notaP2,
                                'peso_da_nota'=> 6
                            ];

                        }
                    }

                    $aluno_disciplina[] = [
                        'aluno_id'=> $aluno->id,
                        'disciplina_id'=> $disciplina->id,
                        'situacao_id'=>((($notaP1 * 4 + $notaP2 * 6)/10)>=5)? 1: 2,
                        'nota_final'=> (($notaP1 * 4 + $notaP2 * 6)/10)
                    ];
                }
            }
        }
        $this->insertDatas('aluno_disciplina', $aluno_disciplina);
        $this->insertDatas('notas', $notas);
    }


    protected function inserirAlunoArea()
    {
        echo "    start inserirAlunoArea()". PHP_EOL;
        $aluno_area = [];

        foreach(\App\Models\Aluno::all() as $aluno)
        {
            foreach( $aluno->getAlunoAreaByDisciplina() as $area)
            {
                $soma = 0;
                $num_disciplina = 0;
                foreach($aluno->disciplinas as $disciplina)
                {
                    if( $disciplina->hasAreasDeConhecimento($area->id))
                    {
                        $soma += $disciplina->pivot->nota_final;
                        $num_disciplina ++;                        
                    }                    
                }
                if($soma!=0){
                    $aluno_area[] = [
                        'aluno_id'=> $aluno->id,
                        'areas_de_conhecimento_id'=> $area->id,
                        'valor_calculado_por_notas'=> ($soma/$num_disciplina)
                    ];
                }
            }
        }
        echo "        INSERT inserirAlunoArea()". PHP_EOL;
        $this->insertDatas('aluno_areas_de_conhecimento', $aluno_area);
    }
}
