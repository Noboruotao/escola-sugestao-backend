<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Validation\Rules\Exists;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Classe;
use App\Models\Professor;
use App\Models\Disciplina;

class ClasseFactory extends customFactory
{
    public function definition()
    {
        dump('Starting Classe seeding');
        $classe = new ClasseFactory();

        $classe->insertClasse();
        $classe->alunoClasse();
    }


    protected function insertClasse()
    {
        echo "    start insertClasse()" . PHP_EOL;

        $disciplinas = Disciplina::all();
        $professores = Professor::all();
        $datas = [];

        foreach ($disciplinas as $disciplina) {
            $validProfessors = $professores->filter(function ($professor) use ($disciplina) {
                return $disciplina->areas->intersect($professor->professorAreas())->isNotEmpty();
            });

            if ($validProfessors->isNotEmpty()) {
                $randomProfessor = $validProfessors->random();
                $datas[] = [
                    'professor_id' => $randomProfessor->id,
                    'disciplina_id' => $disciplina->id,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        $this->insertDatas('classes', $datas);
    }


    protected function alunoClasse()
    {
        echo "    start alunoClasse()" . PHP_EOL;

        Classe::orderBy('id')->chunk(500, function (Collection $classes) {
            foreach ($classes as $classe) {
                $disciplina = $classe->disciplina;

                if (count($disciplina->anos) != 0) {
                    $alunos = $disciplina->anos[0]->alunos;
                    foreach ($alunos as $aluno) {
                        $datasAlunoClasse[] = [
                            'aluno_id' => $aluno->id,
                            'classe_id' => $classe->id
                        ];

                        $datasAlunoDisciplina[] = [
                            'aluno_id' => $aluno->id,
                            'disciplina_id' => $disciplina->id,
                            'situacao_id' => 5
                        ];
                    }
                }
            }
            $this->insertDatas('aluno_classe', $datasAlunoClasse);
            $this->insertDatas('aluno_disciplina', $datasAlunoDisciplina);
        });
        $this->insertDatas('aluno_classe', $datasAlunoClasse);
        $this->insertDatas('aluno_disciplina', $datasAlunoDisciplina);
    }
}
