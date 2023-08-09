<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\Aluno;
use App\Models\AlunoDisciplina;
use App\Models\Disciplina;
use App\Models\Periodo;
use App\Models\Nota;

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


    private static function alunoDisciplinaAtual($aluno)
    {
        $alunoDisciplina = [];
        foreach ($aluno->periodo->disciplinas as $disciplina) {
            $alunoDisciplina[] = AlunoFactory::makeAlunoDisciplina($aluno->id, $disciplina->id, 5, null);
        }
        return $alunoDisciplina;
    }


    public static function generateNotaValue($target, $probability = 0.7)
    {
        $faker = \Faker\Factory::create('pt_BR');
        $randomValue = $faker->randomFloat(2, 0, 10);
        if ($faker->randomFloat(2, 0, 1) < $probability) {
            $randomValue = $target - (10 - $target) * $faker->randomFloat(2, 0, 1);
        }
        return $randomValue;
    }


    private static function attributeAlunoDisciplina()
    {

        $all_periodos = Periodo::all();
        Aluno::orderBy('id')->chunk(100, function (Collection $alunos) use ($all_periodos) {
            $alunoDisciplina = [];
            foreach ($alunos as $aluno) {
                $periodos = $all_periodos->where('id', '<', $aluno->periodo_id);
                $alunoDisciplina = AlunoFactory::alunoDisciplinaAtual($aluno);
                foreach ($periodos as $periodo) {
                    foreach ($periodo->disciplinas as $disciplina) {
                        $notas = [];
                        $nota_p1 = AlunoFactory::generateNotaValue(0, 10.00, 9.00);
                        $nota_p2 = AlunoFactory::generateNotaValue(0, 10.00, 9.00);
                        $nota_final = ($nota_p1 + $nota_p2) / 2;

                        $notas[] = AlunoFactory::makeNota($aluno->id, 1, $disciplina->id, $nota_p1);
                        $notas[] = AlunoFactory::makeNota($aluno->id, 2, $disciplina->id, $nota_p2);

                        if ($nota_final < 5) {
                            $nota_sub = AlunoFactory::generateNotaValue(0, 10.00, 9.00);
                            $notas[] = AlunoFactory::makeNota($aluno->id, 4, $disciplina->id, $nota_sub);

                            if ($nota_p1 < $nota_p2) {
                                $nota_final = ($nota_sub + $nota_p2) / 2;
                            } else {
                                $nota_final = ($nota_p1 + $nota_sub) / 2;
                            }
                        }
                        $alunoDisciplina[] = AlunoFactory::makeAlunoDisciplina($aluno->id, $disciplina->id, ($nota_final >= 5) ? 1 : 2, $nota_final);
                        Nota::insert($notas);
                    }
                }
            }
            AlunoDisciplina::insert($alunoDisciplina);
        });
    }
}
