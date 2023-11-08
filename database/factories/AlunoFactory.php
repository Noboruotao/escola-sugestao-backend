<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use App\Models\Aluno;
use App\Models\AlunoDisciplina;
use App\Models\AtividadeExtra;
use App\Models\Aula;
use App\Models\Classe;
use App\Models\Disciplina;
use App\Models\Periodo;
use App\Models\Nota;
use App\Models\Professor;
use App\Models\Bolsa;
use App\Models\DisciplinaSituacao;
use App\Models\Pagamento;
use App\Models\TipoAvaliacao;

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
        self::createClasses();
        self::createAulas();
        self::callAttributeAlunoArea();
        self::attributeBolsas();
        self::attributeAlunoAtivExtra();
    }


    private static function makeNota(
        $aluno_id,
        $tipo_id,
        $disciplina_id,
        $nota,
        $classe_id
    ) {
        return [
            'aluno_id' => $aluno_id,
            'tipo_avaliacao_id' => $tipo_id,
            'disciplina_id' => $disciplina_id,
            'nota' => $nota,
            'classe_id' => $classe_id
        ];
    }


    private static function makeAlunoDisciplina(
        $aluno_id,
        $disciplina_id,
        $situacao_id,
        $nota_final = null
    ) {
        return [
            'aluno_id' => $aluno_id,
            'disciplina_id' => $disciplina_id,
            'situacao_id' => $situacao_id,
            'nota_final' => $nota_final,
        ];
    }


    private static function generateRandomNota(
        $target,
        $probability = 0.8,
        $faker
    ) {
        $randomValue = 10 - (10 - $target) * $faker->randomFloat(2, 0, 1 - $probability);
        return $randomValue;
    }


    private static function calculateFinalNota(
        $nota_p1,
        $nota_p2,
        $nota_sub
    ) {
        if ($nota_sub !== null) {
            return max(
                ($nota_p1 + $nota_sub) / 2,
                ($nota_p2 + $nota_sub) / 2,
                ($nota_p1 + $nota_p2) / 2
            );
        }
        return ($nota_p1 + $nota_p2) / 2;
    }


    private static function generateNotasForDisciplina(
        $aluno_id,
        $disciplina_id,
        $classe_id,
        $faker
    ) {
        $nota_p1 = self::generateRandomNota(
            3.00,
            null,
            $faker
        );
        $nota_p2 = self::generateRandomNota(
            3.00,
            null,
            $faker
        );
        $nota_sub = null;

        if (self::calculateFinalNota($nota_p1, $nota_p2, null) < 5) {
            $nota_sub = self::generateRandomNota(10.00, null, $faker);
        }

        $nota_final = self::calculateFinalNota(
            $nota_p1,
            $nota_p2,
            $nota_sub
        );

        $notasArray = [
            self::makeNota(
                $aluno_id,
                TipoAvaliacao::P1,
                $disciplina_id,
                $nota_p1,
                $classe_id
            ),
            self::makeNota(
                $aluno_id,
                TipoAvaliacao::P2,
                $disciplina_id,
                $nota_p2,
                $classe_id
            ),
        ];

        if ($nota_sub !== null) {
            $notasArray[] = self::makeNota(
                $aluno_id,
                TipoAvaliacao::P_SUB,
                $disciplina_id,
                $nota_sub,
                $classe_id
            );
        }

        return $notasArray;
    }


    private static function generateAlunoDisciplina(
        $aluno,
        $all_periodos
    ) {
        $faker = \Faker\Factory::create('pt_BR');

        $alunoDisciplina = [];
        $notas = [];

        foreach ($aluno->periodo->disciplinas as $disciplina) {
            $alunoDisciplina[] = self::makeAlunoDisciplina(
                $aluno->id,
                $disciplina->id,
                DisciplinaSituacao::EM_ANDAMENTO,
                null
            );
        }

        foreach ($all_periodos as $periodo) {
            if ($periodo->id < $aluno->periodo_id) {
                foreach ($periodo->disciplinas as $disciplina) {

                    $notasDisciplina = self::generateNotasForDisciplina(
                        $aluno->id,
                        $disciplina->id,
                        $faker
                    );
                    $nota_final = (count($notasDisciplina) == 3) ?
                        self::calculateFinalNota(
                            $notasDisciplina[0]['nota'],
                            $notasDisciplina[1]['nota'],
                            $notasDisciplina[2]['nota']
                        )
                        :  self::calculateFinalNota(
                            $notasDisciplina[0]['nota'],
                            $notasDisciplina[1]['nota'],
                            null
                        );

                    $alunoDisciplina[] = self::makeAlunoDisciplina(
                        $aluno->id,
                        $disciplina->id,
                        ($nota_final >= 5)
                            ? DisciplinaSituacao::APROVADO
                            : DisciplinaSituacao::REPROVADO,
                        $nota_final
                    );
                    $notas = array_merge($notas, $notasDisciplina);
                }
            }
        }
        Nota::insert($notas);
        return $alunoDisciplina;
    }


    public static function callAttributeAlunoArea()
    {
        echo 'attributeAlunoDisciplina' . PHP_EOL;
        $all_periodos = Periodo::all();

        Aluno::orderBy('id')
            ->chunk(200, function (Collection $alunos) use ($all_periodos) {
                foreach ($alunos as $aluno) {
                    //     $alunoDisciplina = self::generateAlunoDisciplina(
                    //         $aluno,
                    //         $all_periodos
                    //     );
                    //     AlunoDisciplina::insert($alunoDisciplina);
                    self::attributeAlunoArea($aluno);
                }
            });
    }


    private static function attributeAlunoArea($aluno)
    {
        foreach ($aluno->disciplinas as $disciplina) {
            $aluno->AttributeAlunoAreaByNota($disciplina);
        }
    }


    private static function makeClasse(
        $professor_id,
        $disciplina_id,
        $ativo,
        $ano
    ) {
        return Classe::create([
            'professor_id' => $professor_id,
            'disciplina_id' => $disciplina_id,
            'ativo' => $ativo,
            'ano' => $ano,
        ]);
    }


    private static function makePresenca(
        $minPresenca = 75,
        $total = 51
    ) {
        $minValue = $total * ($minPresenca / 100);
        $presenca = mt_rand($minValue, $total);
        return [
            'presenca' => $presenca,
            'faltas' => $total - $presenca,
        ];
    }


    private static function attributeAlunoClasse(
        $alunos,
        $classe
    ) {
        $faker = \Faker\Factory::create('pt_BR');

        $alunoDisciplina = [];
        $notas = [];

        foreach ($alunos as $aluno) {
            $classe->alunos()
                ->attach($aluno, self::makePresenca(75, 51));
            if ($classe->ativo == 1 && $classe->disciplina_id) {
                $alunoDisciplina[] = self::makeAlunoDisciplina(
                    $aluno->id,
                    $classe->disciplina_id,
                    DisciplinaSituacao::EM_ANDAMENTO,
                    null
                );
            } elseif ($classe->disciplina_id) {
                $notasDisciplina = self::generateNotasForDisciplina(
                    $aluno->id,
                    $classe->disciplina_id,
                    $classe->id,
                    $faker
                );
                $nota_final = (count($notasDisciplina) == 3) ?
                    self::calculateFinalNota(
                        $notasDisciplina[0]['nota'],
                        $notasDisciplina[1]['nota'],
                        $notasDisciplina[2]['nota']
                    )
                    :  self::calculateFinalNota(
                        $notasDisciplina[0]['nota'],
                        $notasDisciplina[1]['nota'],
                        null
                    );

                $alunoDisciplina[] = self::makeAlunoDisciplina(
                    $aluno->id,
                    $classe->disciplina_id,
                    ($nota_final >= 5)
                        ? DisciplinaSituacao::APROVADO
                        : DisciplinaSituacao::REPROVADO,
                    $nota_final
                );
                $notas = array_merge(
                    $notas,
                    $notasDisciplina
                );
            }
        }
        Nota::insert($notas);
        AlunoDisciplina::insert($alunoDisciplina);
        self::attributeAlunoArea($aluno);
    }


    private static function createClasses()
    {
        echo 'createClasses' . PHP_EOL;

        $professorIds = Professor::pluck('id');
        $currentYear = Carbon::now()->year;
        $periodos = Periodo::with('disciplinas', 'alunos')
            ->get();
        foreach ($periodos as $periodo) {
            self::processPeriodo(
                $periodo,
                $professorIds,
                $currentYear,
                $periodos
            );
        }
    }

    private static function processPeriodo(
        $periodo,
        $professorIds,
        &$currentYear,
        $allPeriodos
    ) {
        $alunos = $periodo->alunos;
        $ano = $currentYear;

        foreach ($allPeriodos->where(
            'id',
            '<=',
            $periodo->id
        )
            ->sortByDesc('id') as $subPeriodo) {
            $ativo = ($subPeriodo->id === $periodo->id)
                ? 1
                : 0;
            $disciplinas = $subPeriodo->disciplinas;

            if ($disciplinas->isEmpty()) {
                $classe = self::makeClasse(
                    $professorIds->random(),
                    null,
                    $ativo,
                    $ano
                );
                self::attributeAlunoClasse($alunos, $classe);
            } else {
                self::processDisciplinas(
                    $disciplinas,
                    $alunos,
                    $professorIds,
                    $ativo,
                    $ano
                );
            }
            $ano--;
        }
    }

    private static function processDisciplinas(
        $disciplinas,
        $alunos,
        $professorIds,
        $ativo,
        &$ano
    ) {
        list($turmaA, $turmaB) = $alunos->split(2);

        foreach ($disciplinas as $disciplina) {
            $professorIdA = $professorIds->random();
            $professorIdB = $professorIds->random();

            $classeA = self::makeClasse(
                $professorIdA,
                $disciplina->id,
                $ativo,
                $ano
            );
            $classeB = self::makeClasse(
                $professorIdB,
                $disciplina->id,
                $ativo,
                $ano
            );

            self::attributeAlunoClasse(
                $turmaA,
                $classeA
            );
            self::attributeAlunoClasse(
                $turmaB,
                $classeB
            );
        }
    }


    private static function createAulas()
    {
        echo 'createAulas' . PHP_EOL;
        Classe::whereNotNull('disciplina_id')
            ->orderBy('id')
            ->chunk(100, function ($classes) {
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


    private static function attributeBolsas()
    {
        $faker = \Faker\Factory::create('pt_BR');
        $bolsas = Bolsa::all();
        Aluno::orderBy('id')
            ->chunk(200, function (Collection $alunos) use ($faker, $bolsas) {
                foreach ($alunos as $aluno) {
                    $pagamentos = [];
                    if ($faker->boolean(10)) {
                        $aluno->bolsas()->attach($bolsas->random());
                    }
                    $pagamentos = array_merge(
                        $pagamentos,
                        self::createPagamentosForAluno($aluno)
                    );
                }
                Pagamento::insert($pagamentos);
            });
    }


    private static function createPagamento($aluno, $startDate)
    {
        $faker = \Faker\Factory::create('pt_BR');
        $validade = $startDate->copy()
            ->day(10);
        $nextValidade = $validade->copy()
            ->addMonth()
            ->day(10);
        $pago = $faker->dateTimeBetween(
            $validade,
            $nextValidade
        );
        $valor = 1200 - $aluno->bolsaValor();

        return [
            'aluno_id' => $aluno->id,
            'valor' => $valor,
            'validade' => $nextValidade,
            'pago' => $pago,
        ];
    }


    private static function calculateStartDate($periodo)
    {
        $currentDate = Carbon::now();
        $nineYearsAgo = $currentDate->subYears($periodo - 1);
        $startOfYear = $nineYearsAgo->startOfYear();
        return $startOfYear;
    }


    private static function createPagamentosForAluno($aluno)
    {
        $pagamentos = [];
        $startDate = self::calculateStartDate($aluno->periodo_id);
        $endDate = Carbon::now();

        while ($startDate->lt($endDate)) {
            $pagamento = self::createPagamento($aluno, $startDate);
            $pagamentos[] = $pagamento;

            $startDate->addMonth();
        }

        return $pagamentos;
    }

    public static function attributeAlunoAtivExtra()
    {
        $ativExtras = AtividadeExtra::all();
        $faker = \Faker\Factory::create('pt_BR');
        Aluno::orderBy('id')
            ->where('periodo_id', '>', 2)
            ->chunk(200, function ($alunos) use ($ativExtras, $faker) {
                foreach ($alunos as $aluno) {
                    if ($faker->boolean(30)) {
                        $aluno->attributeAtivExtra($ativExtras->random());
                    }
                }
            });
    }
}
