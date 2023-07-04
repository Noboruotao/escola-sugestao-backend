<?php

namespace Database\Factories;

use App\Models\Emprestimo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

use App\Models\Pessoa;
use App\Models\Aluno;
use App\Models\Acervo;

class EmprestimoFactory extends customFactory
{
    protected $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create('pt_BR');
    }

    public function definition()
    {
        dump('Starting Emprestimo seeding');
        $emprestimos = new EmprestimoFactory();

        $emprestimos->makeEmprestimos();
        $emprestimos->attributeAcervoAreasToAluno();
        $emprestimos->insertMultas();
    }


    protected function makeEmprestimos()
    {
        echo "    start makeEmprestimos()" . PHP_EOL;

        $bibliotecarios = Pessoa::getPessoaByRole('Bibliotecário');
        $acervos = Acervo::pluck('id');

        Aluno::whereBetween('ano_id', [6, 17])
            ->orderBy('id')
            ->chunk(100, function (Collection $pessoas) use ($bibliotecarios, $acervos) {
                $emprestimos = [];

                foreach ($pessoas as $pessoa) {
                    $numero_de_emprestimos = $this->faker->numberBetween($min = 0, $max = 100);

                    for ($i = 0; $i < $numero_de_emprestimos; $i++) {
                        $data_de_emprestimo = $this->faker->dateTimeBetween($startDate = '-3 years', $endDate = '-1 week');
                        $data_de_devolucao = $this->faker->dateTimeBetween($data_de_emprestimo, '+20 days');

                        $emprestimos[] = [
                            'acervo_id' => $acervos->random(),
                            'bibliotecario_id' => $this->faker->randomElement($bibliotecarios)->id,
                            'leitor_id' => $pessoa->id,
                            'data_de_emprestimo' => $data_de_emprestimo,
                            'data_de_devolucao' => $data_de_devolucao,
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                }
                $this->insertDatas('emprestimos', $emprestimos);
            });
    }


    protected function getAreasFromAcervos($acervos)
    {
        $areas = collect();
        foreach ($acervos as $acervo) {
            $areas = $areas->merge(($acervo->areas)->diff($areas));
        }
        return $areas;
    }


    protected function attributeAcervoAreasToAluno()
    {
        echo "    start attributeAcervoAreasToAluno()" . PHP_EOL;

        Emprestimo::whereIn('leitor_id', Aluno::pluck('id')->toArray())
            ->orderBy('id')
            ->chunk(500, function (Collection $todos_emprestimos) {
                $alunoIds = $todos_emprestimos->pluck('leitor_id')->toArray();
                $acervoIds = $todos_emprestimos->pluck('acervo_id')->toArray();

                $alunos = Aluno::whereIn('id', $alunoIds)->with('areas')->get();
                $acervos = Acervo::whereIn('id', $acervoIds)->get();

                foreach ($todos_emprestimos as $emprestimo) {
                    $aluno = $alunos->where('id', $emprestimo->leitor_id)->first();
                    $acervo = $acervos->where('id', $emprestimo->acervo_id)->first();

                    if ($aluno && $acervo) {
                        Emprestimo::updateAlunoAreas($aluno, $acervo);
                    }
                }
            });
    }


    protected function insertMultas()
    {
        echo "    start insertMultas()" . PHP_EOL;

        Emprestimo::whereDate('data_de_devolucao', '>', Carbon::now()->subDays(14))
            ->orderBy('id')
            ->chunk(200, function (Collection $emprestimos_atrasados) {
                foreach ($emprestimos_atrasados as $emprestimo) {
                    $data_de_emprestimo = Carbon::parse($emprestimo->data_de_emprestimo);
                    $data_de_devolucao = Carbon::parse($emprestimo->data_de_devolucao);

                    $dias_atrasados = $data_de_devolucao->diffInDays($data_de_emprestimo);

                    $datas[] = [
                        'emprestimo_id' => $emprestimo->id,
                        'dias_atrasados' => $dias_atrasados,
                        'valor_da_multa' => max(0, ($dias_atrasados - 14) * $emprestimo->acervo->tipo->multa),
                        'pago' => $data_de_devolucao,
                    ];
                }
                $this->insertDatas('multas', $datas);
            });
    }


}
