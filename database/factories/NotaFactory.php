<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Aluno;

class NotaFactory extends customFactory
{
    
    public function definition()
    {
        dump('Starting Nota seeding');
        $notas = new NotaFactory();

        $notas->insertNotas();
        $notas->inserirAlunoArea();
        $notas->attributeAtivExtraAreasToAluno();

    }


    protected function gerarRandomNota()
    {
        return ($this->faker->biasedNumberBetween($min = 0, $max = 1000, $function = 'sqrt', $bias = 4.0) / 100.0);
    }


    protected function insertNotas()
    {
        echo "    start insertNotas()". PHP_EOL;

        $todos_anos = \App\Models\Ano::all();
        Aluno::orderBy('id')->chunk(500, function (Collection $alunos) use ($todos_anos){
            foreach( $alunos as $aluno )
            {
                for($i=1; $i<($aluno->ano->id); $i++)
                {
                    $disciplinas = $todos_anos->where('id', $i)->first()->disciplinas;
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
        });
    }


    protected function inserirAlunoArea()
    {
        echo "    start inserirAlunoArea()". PHP_EOL;

        Aluno::orderBy('id')->chunk(500, function (Collection $alunos) {
            foreach($alunos as $aluno)
            {
                foreach( $aluno->getAlunoAreaByDisciplina() as $area)
                {
                    $soma = 0;
                    $num_disciplina = 0;
                    foreach($aluno->disciplinas as $disciplina)
                    {
                        if( $disciplina->areas->contains($area))
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
            $this->insertDatas('aluno_areas_de_conhecimento', $aluno_area);
        });
    }


    protected function attributeAtivExtraAreasToAluno()
    {
        echo "    start attributeAtivExtraAreasToAluno()". PHP_EOL; 

        Aluno::orderBy('id')->chunk(500, function (Collection $alunos) {
            foreach($alunos as $aluno)
            {
                foreach($aluno->atividades_extracurriculares as $ativExtra)
                {
                    \App\Models\AtividadesExtracurriculares::updateAlunoAreas($aluno, $ativExtra);
                }
            }
        });
    }
}
