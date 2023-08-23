<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use App\Models\Aluno;
use App\Models\AlunoDisciplina;
use App\Models\Aula;
use App\Models\Classe;
use App\Models\Disciplina;
use App\Models\Periodo;
use App\Models\Nota;
use App\Models\Professor;

class AlunoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        dump('Starting Aluno seeding');
        AlunoFactory::attributeAlunoDisciplina();
        AlunoFactory::createClasses();
        AlunoFactory::createAulas();
    }


    private static function makeNota($aluno_id, $tipo_id, $disciplina_id, $nota)
    {
        return [
            'aluno_id' => $aluno_id,
            'tipo_avaliacao_id' => $tipo_id,
            'disciplina_id' => $disciplina_id,
            'nota' => $nota,
        ];
    }


    private static function makeAlunoDisciplina($aluno_id, $disciplina_id, $situacao_id, $nota_final = null)
    {
        return [
            'aluno_id' => $aluno_id,
            'disciplina_id' => $disciplina_id,
            'situacao_id' => $situacao_id,
            'nota_final' => $nota_final,
        ];
    }


    private static function generateRandomNota($target, $probability = 0.7)
    {
        $faker = \Faker\Factory::create('pt_BR');
        $randomValue = $faker->randomFloat(2, 0, 10);
        if ($faker->randomFloat(2, 0, 1) < $probability) {
            $randomValue = $target - (10 - $target) * $faker->randomFloat(2, 0, 1);
        }
        return $randomValue;
    }


    private static function calculateFinalNota($nota_p1, $nota_p2, $nota_sub)
    {
        if ($nota_sub !== null) {
            return max(($nota_p1 + $nota_sub) / 2, ($nota_p2 + $nota_sub) / 2, ($nota_p1 + $nota_p2) / 2);
        }
        return ($nota_p1 + $nota_p2) / 2;
    }


    private static function generateNotasForDisciplina($aluno_id, $disciplina_id)
    {
        $nota_p1 = self::generateRandomNota(9.00);
        $nota_p2 = self::generateRandomNota(9.00);
        $nota_sub = null;

        if (self::calculateFinalNota($nota_p1, $nota_p2, null) < 5) {
            $nota_sub = self::generateRandomNota(9.00);
            $nota_final = self::calculateFinalNota($nota_p1, $nota_p2, $nota_sub);
        } else {
            $nota_final = self::calculateFinalNota($nota_p1, $nota_p2, null);
        }

        $notasArray = [
            self::makeNota($aluno_id, 1, $disciplina_id, $nota_p1),
            self::makeNota($aluno_id, 2, $disciplina_id, $nota_p2),
        ];

        if ($nota_sub !== null) {
            $notasArray[] = self::makeNota($aluno_id, 4, $disciplina_id, $nota_sub);
        }

        return $notasArray;
    }



    private static function generateAlunoDisciplina($aluno, $all_periodos)
    {
        $alunoDisciplina = [];

        foreach ($aluno->periodo->disciplinas as $disciplina) {
            $alunoDisciplina[] = self::makeAlunoDisciplina($aluno->id, $disciplina->id, 5, null);
        }

        foreach ($all_periodos as $periodo) {
            if ($periodo->id < $aluno->periodo_id) {
                foreach ($periodo->disciplinas as $disciplina) {
                    $notas = self::generateNotasForDisciplina($aluno->id, $disciplina->id);
                    $nota_final = (count($notas) == 3) ?
                        self::calculateFinalNota($notas[0]['nota'], $notas[1]['nota'], $notas[2]['nota'])
                        :  self::calculateFinalNota($notas[0]['nota'], $notas[1]['nota'], null);

                    $alunoDisciplina[] = self::makeAlunoDisciplina($aluno->id, $disciplina->id, ($nota_final >= 5) ? 1 : 2, $nota_final);
                    Nota::insert($notas);
                }
            }
        }
        return $alunoDisciplina;
    }


    public static function attributeAlunoDisciplina()
    {
        echo 'attributeAlunoDisciplina' . PHP_EOL;
        $all_periodos = Periodo::all();

        Aluno::orderBy('id')->chunk(200, function (Collection $alunos) use ($all_periodos) {
            foreach ($alunos as $aluno) {
                $alunoDisciplina = self::generateAlunoDisciplina($aluno, $all_periodos);
                AlunoDisciplina::insert($alunoDisciplina);
                AlunoFactory::attributeAlunoArea($aluno);
            }
        });
    }


    private static function attributeAlunoArea($aluno)
    {
        foreach ($aluno->disciplinas as $disciplina) {
            $aluno->AttributeAlunoAreaByNota($disciplina->id);
        }
    }


    private static function makeClasse($professor_id, $disciplina_id, $ativo, $ano)
    {
        return Classe::create([
            'professor_id' => $professor_id,
            'disciplina_id' => $disciplina_id,
            'ativo' => $ativo,
            'ano' => $ano,
        ]);
    }


    private static function makePresenca($minPresenca = 75, $total = 51)
    {
        $minValue = $total * ($minPresenca / 100);
        $presenca = mt_rand($minValue, $total);
        return [
            'presenca' => $presenca,
            'faltas' => $total - $presenca,
        ];
    }



    private static function attributeAlunoClasse($alunos, $classe)
    {
        foreach ($alunos as $aluno) {
            $classe->alunos()->attach($aluno, self::makePresenca(75, 51));
        }
    }


    private static function createClasses()
    {
        echo 'createClasses' . PHP_EOL;
        $professor_ids = Professor::pluck('id');
        $currentYear = Carbon::now()->year;

        foreach (Periodo::all() as $periodo) {
            $alunoClasse = [];
            $alunos = $periodo->alunos;
            $ano = $currentYear;
            foreach (Periodo::orderBy('id', 'desc')->where('id', '<=', $periodo->id)->get() as $sub_periodo) {
                $ativo = $sub_periodo->id == $periodo->id ? true : false;
                $disciplinas = $sub_periodo->disciplinas;
                if ($disciplinas->isEmpty()) {
                    $classe = self::makeClasse($professor_ids->random(), null, $ativo, $ano);
                    self::attributeAlunoClasse($alunos, $classe);
                } else {
                    list($turma_a, $turma_b) = $alunos->split(2);
                    foreach ($disciplinas as $disciplina) {
                        $classe_a = self::makeClasse($professor_ids->random(), $disciplina->id, $ativo, $ano);
                        $classe_b = self::makeClasse($professor_ids->random(), $disciplina->id, $ativo, $ano);
                        self::attributeAlunoClasse($turma_a, $classe_a);
                        self::attributeAlunoClasse($turma_b, $classe_b);
                    }
                }
                $ano--;
            }
        }
    }


    private static function createAulas()
    {
        echo 'createAulas' . PHP_EOL;
        Classe::whereNotNull('disciplina_id')->orderBy('id')->chunk(500, function ($classes) {
            $aulas = [];
            foreach ($classes as $classe) {
                $aulas[] = [
                    'classe_id' => $classe->id,
                    'dia_semana' => 'dia de semana',
                    'horario' => 'horario',
                ];
            }
            Aula::insert($aulas);
        });
    }
}
