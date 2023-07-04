<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

use App\Models\Aluno;
use App\Models\Pessoa;
use App\Models\Curso;

use App\Models\NivelEscolar;
use App\Models\Ano;
use App\Models\Bolsa;


class PessoaCursoFactory extends customFactory
{
    protected array $seederDatas;
    protected $faker;


    public function __construct()
    {
        $this->seederDatas = config('seeder_datas.pessoaCursoSeederData');
        $this->faker = \Faker\Factory::create('pt_BR');
    }

    public function definition($num_pessoas = 1000)
    {
        dump('Starting Pessoa seeding');
        $pessoa_curso = new PessoaCursoFactory();

        $pessoa_curso->inserirCursos();
        $pessoa_curso->insertBolsas();
        $pessoa_curso->inserirSituacaoAluno();

        $pessoa_curso->insertNivelEscolar();
        $pessoa_curso->insertAno();
        $pessoa_curso->makePessoa($num_pessoas);

        $pessoa_curso->makeProfessor();
        $pessoa_curso->makeAluno();
        $pessoa_curso->makePais();

        $pessoa_curso->insertMensalidade();
    }


    /**
     * manda array para customFactory::insertDatas()
     * @return array
     */
    protected function inserirCursos()
    {
        echo "    start inserirCursos()" . PHP_EOL;
        $this->verifyTable('cursos', $this->seederDatas['cursos']);
    }


    /**
     * manda array para customFactory::insertDatas()
     * @return array
     */
    protected function insertBolsas()
    {
        echo "    start insertBolsas()" . PHP_EOL;
        $this->verifyTable('bolsas', $this->seederDatas['bolsas']);
    }


    /**
     * manda array para customFactory::insertDatas()
     * @return array
     */
    protected function inserirSituacaoAluno()
    {
        echo "    start inserirSituacaoAluno()" . PHP_EOL;
        $this->verifyTable('situacao_aluno', $this->seederDatas['situacao']);
    }


    /**
     * manda array para customFactory::insertDatas()
     * @return array
     */
    protected function insertNivelEscolar()
    {
        echo "    start insertNivelEscolar()" . PHP_EOL;
        $this->verifyTable('nivel_escolar', $this->seederDatas['nivel_escolar']);
    }


    /**
     * manda array para customFactory::insertDatas()
     * @return array
     */
    protected function insertAno()
    {
        echo "    start insertAno()" . PHP_EOL;

        $niveis_escolar = NivelEscolar::all();

        foreach ([['Ensino Infantil', 5], ['Ensino Fundamental', 9], ['Ensino Médio', 3], ['Cursos Técnicos', 3], ['Cursos Preparatórios', 1]] as $nivel) {
            for ($i = 1; $i <= $nivel[1]; $i++) {
                $data[] = [
                    'nivel_escolar_id' => $niveis_escolar->where('nome', $nivel[0])->first()->id,
                    'ano' => $i
                ];
            }
        }
        $this->verifyTable('anos', $data);
    }


    protected function verifyIfValueExists($coluna, $pessoas, callable $callback, &$current_datas)
    {
        do {
            $value = $callback();
            if (in_array($value, $current_datas) || $pessoas->contains($coluna, $value)) {
                $email = null;
            }
        } while ($value == null);
        $current_datas[] = [$coluna => $value];
        return $value;
    }


    /**
     * manda array para customFactory::insertDatas()
     * @int $numero_de_pessoas
     * @return array
     */
    protected function makePessoa($numero_de_pessoa)
    {
        echo "    start makePessoa()" . PHP_EOL;
        $pessoas = collect();

        $emailExistentes = Pessoa::pluck('email')->toArray();
        $rgExistentes = Pessoa::pluck('rg')->toArray();
        $cpfExistentes = Pessoa::pluck('cpf')->toArray();

        try {
            while ($numero_de_pessoa > 0) {

                $genero = $this->faker->randomElement(['Masculino', 'Feminino']);

                $data_nascimento = $this->faker->dateTimeBetween('-' . $this->faker->biasedNumberBetween(2, 50, function ($x) {
                    return 18 - $x;
                }) . ' years', '-1 years')->format('Y-m-d');

                $idade = $this->getIdade($data_nascimento);

                if ($genero == 'Masculino') {
                    $prim_nome = $this->faker->firstNameMale();
                    $foto_path = 'images/pessoas_foto/man_';
                    $age_group = ($idade < 10) ? 'boy_' : (($idade < 18) ? 'youngman_' : 'man_');
                    $photo_numbers = ['49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60'];
                } else {
                    $prim_nome = $this->faker->firstNameFemale();
                    $foto_path = 'images/pessoas_foto/woman_';
                    $age_group = ($idade < 10) ? 'girl_' : (($idade < 18) ? 'youngwoman_' : 'woman_');
                    $photo_numbers = ['61', '62', '63', '64', '65', '66', '67', '68', '69', '70', '71', '72'];
                }

                $foto = $foto_path . $this->faker->randomElement($photo_numbers) . '.png';

                $cpf = $this->verifyIfValueExists('cpf', $pessoas, function () {
                    return $this->faker->cpf();
                }, $cpfExistentes);

                $rg = $this->verifyIfValueExists('rg', $pessoas, function () {
                    return $this->faker->rg();
                }, $rgExistentes);

                $email = $this->verifyIfValueExists('email', $pessoas, function () use ($prim_nome) {
                    return $email = $prim_nome . $this->faker->numerify('####') . '.' . $this->faker->email();
                }, $emailExistentes);

                $last_nome = $this->faker->lastName();

                $pessoas->push([
                    'nome' => $prim_nome . ' ' . $last_nome,
                    'primeiro_nome' => $prim_nome,
                    'ultimo_nome' => $last_nome,
                    'email' => $email,
                    'data_de_nascimento' => $data_nascimento,
                    'genero' => $genero,
                    'cpf' => $cpf,
                    'rg' => $rg,
                    'endereco' => $this->faker->address(),
                    'telefone' => (rand(0, 1)) ? $this->faker->landline() : null,
                    'celular' => (rand(0, 1)) ? $this->faker->cellphone() : null,
                    'senha' => \Illuminate\Support\Facades\Hash::make('password'),
                    'foto' => $foto,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $numero_de_pessoa--;

                if ($pessoas->count() >= 500) {
                    $this->insertDatas('pessoas', $pessoas);
                };
            }

            $this->insertDatas('pessoas', $pessoas);
        } catch (\Exception $e) {
            throw $e;
        }
    }


    /**
     * @array $ids
     * @return array
     */
    protected function makeProfessor()
    {
        echo "    start makeProfessor()" . PHP_EOL;
        $cursos = Curso::all();

        $limit = ceil(Pessoa::whereRaw('DATEDIFF(CURDATE(), data_de_nascimento) / 365 > 18')->count() / 10);

        Pessoa::whereRaw('DATEDIFF(CURDATE(), data_de_nascimento) / 365 > 18')->limit($limit)->orderBy('id')->chunk(200, function (Collection $professors) use ($cursos) {
            foreach ($professors as $professor) {
                $curso = $cursos->random();

                $curso_professor[] = [
                    'professor_id' => $professor->id,
                    'curso_id' => $curso->id
                ];

                $datas[] = [
                    'id' => $professor->id,
                    'experiencia_profissional' => 'Tem experiência em ' . $this->faker->randomElement(['lecionar ', 'estudar ', 'pesquisar ']) . 'na área de ' . $curso->nome . ' por ' . ($this->faker->numberBetween(1, $this->getIdade($professor->data_de_nascimento) - 18)) . ' anos',
                ];

                if (count($datas) > 200) {
                    $this->insertDatas('professors', $datas);
                }

                if (count($curso_professor) > 200) {
                    $this->insertDatas('curso_professor', $curso_professor);
                };
            }
            $this->insertDatas('professors', $datas);
        });
        $this->insertDatas('curso_professor', $curso_professor);
    }


    protected function makeAluno()
    {
        echo "    start makeAluno()" . PHP_EOL;
        $anos = Ano::all();
        Pessoa::whereRaw('DATEDIFF(CURDATE(), data_de_nascimento) / 365 < 18')->orderBy('id')->chunk(200, function (Collection $alunos) use ($anos) {

            foreach ($alunos as $aluno) {

                $idade = $this->getIdade($aluno->data_de_nascimento);

                $datas[] = [
                    'id' => $aluno->id,
                    'ano_id' => $anos->where('id', $idade)->first()->id,
                    'situacao_id' => $this->faker->randomElement([1, 3, 11])
                ];
            }

            $this->insertDatas('alunos', $datas);
        });

        $this->attributeBolsa();
    }


    protected function attributeBolsa()
    {
        $bolsas = Bolsa::pluck('id');

        Aluno::orderBy('id')->chunk(200, function (Collection $alunos) use ($bolsas) {

            foreach ($alunos as $aluno) {
                if ($this->faker->randomDigit() < 3) {
                    $datas[] = [
                        'aluno_id' => $aluno->id,
                        'bolsa_id' => $bolsas->random(),
                    ];
                }
            }

            $this->insertDatas('aluno_bolsa', $datas);
        });
    }


    protected function makePais()
    {
        echo "    start makePais()" . PHP_EOL;
        $adultos = Pessoa::whereRaw('DATEDIFF(CURDATE(), data_de_nascimento) / 365 > 18')->pluck('id')->toArray();
        Aluno::orderBy('id')->chunk(200, function (Collection $alunos) use ($adultos) {

            foreach ($alunos as $aluno) {
                foreach ($this->faker->randomElements($adultos, $count = rand(1, 2)) as $pai) {
                    $datas[] = [
                        'pais_ou_responsavel_id' => $pai,
                        'aluno_id' => $aluno->id,
                    ];
                }
            }

            $this->insertDatas('pais_ou_responsaveis', $datas);
        });
    }


    protected function insertMensalidade()
    {
        echo "    start insertMensalidade()" . PHP_EOL;
        Aluno::orderBy('id')->chunk(200, function (Collection $alunos) {

            foreach ($alunos as $aluno) {
                $datas[] = [
                    'aluno_id' => $aluno->id,
                    'valor' => Bolsa::getValorMensalidade($id = $aluno->id)
                ];
            }

            $this->insertDatas('mensalidades', $datas);
        });
    }
}
