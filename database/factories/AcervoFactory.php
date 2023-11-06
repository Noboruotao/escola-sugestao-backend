<?php

namespace Database\Factories;

use App\Models\Acervo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\Autor;
use App\Models\Idioma;
use App\Models\Categoria;
use App\Models\AcervoTipo;
use App\Models\AcervoEstado;
use App\Models\AcervoSituacao;
use App\Models\AreaConhecimento;
use App\Models\Nacionalidade;
use App\Models\Editora;
use App\Models\Emprestimo;
use App\Models\Multa;
use App\Models\Pessoa;

class AcervoFactory extends Factory
{

    private const ACERVO_QNT = 500;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        dump('Starting Acervo seeding');

        self::createAutor(50);
        self::createEditoras();
        self::createAcervo();
        self::attributeAcervoAreas();
        self::generateEmprestimos();
    }


    protected static function getBirthYear(
        $faker,
        $max = 25,
        $min = 1000
    ) {
        $maxBirthYear = now()->subYears($max)->year;
        return $faker->numberBetween($maxBirthYear - $min, $maxBirthYear);
    }


    protected static function getDeathYear(
        $faker,
        $ano_nascimento,
        $minLifespan = 20,
        $maxLifespan = 100
    ) {
        $maxDeathYear = $ano_nascimento + $maxLifespan;

        if ($maxDeathYear < now()->subYear()->year || $faker->boolean(30)) {
            $deathYear = $faker->numberBetween($ano_nascimento + $minLifespan, $maxDeathYear);
        } else {
            $deathYear = null;
        }

        return $deathYear;
    }


    public static function createAutor($num = 50)
    {
        $nacionalidades = Nacionalidade::where('id', '<=', 7)->pluck('id');
        $locales = config('seeder_datas.locale');

        for ($index = 0; $index < $num; $index++) {
            $nacionalidade = $nacionalidades->random();
            $faker = \Faker\Factory::create($locales[$nacionalidade]);

            $ano_nascimento = self::getBirthYear($faker, 25, 1000);
            $ano_falecimento = self::getDeathYear(
                $faker,
                $ano_nascimento,
                20,
                100
            );

            $autors[] = [
                'nome' => $faker->name,
                'nacionalidade_id' => $nacionalidade,
                'ano_nascimento' => $ano_nascimento,
                'ano_falecimento' => $ano_falecimento,
            ];
        }
        Autor::insert($autors);
    }


    public static function createEditoras($num = 15)
    {
        $faker = \Faker\Factory::create('pt_BR');
        for ($index = 0; $index < $num; $index++) {
            $endereco = \Database\Factories\PessoaFactory::createEndereco();
            $editoras[] = [
                'nome' => $faker->company,
                'email' => $faker->email,
                'telefone' => $faker->phoneNumber,
                'cnpj' => $faker->unique()
                    ->numerify('##.###.###/####-##'),
                'endereco_id' => $endereco->id,
            ];
        }
        Editora::insert($editoras);
    }


    protected static function getAcervoCapa($tipo)
    {
        $configKeys = [
            4 => 'acervoCapa.4',
            6 => 'acervoCapa.6',
            7 => 'acervoCapa.7',
        ];

        return config('seeder_datas.' . ($configKeys[$tipo] ?? 'acervoCapa.1'));
    }


    public static function createAcervo()
    {
        $autors = Autor::pluck('id');
        $editoras = Editora::pluck('id');
        $categorias = Categoria::pluck('id');
        $tipos = AcervoTipo::pluck('id');
        $estados = AcervoEstado::pluck('id');
        // $situacoes = AcervoSituacao::where('id', '<>', 2)
        $situacoes = AcervoSituacao::where('id', 1)
            ->pluck('id');
        $nomes = AreaConhecimento::pluck('nome');
        $faker = \Faker\Factory::create('pt_BR');
        $acervos = [];
        for ($i = 0; $i < self::ACERVO_QNT; $i++) {
            $acervos[] = self::generateAcervoData(
                $faker,
                $nomes,
                $autors,
                $editoras,
                $categorias,
                $tipos,
                $estados,
                $situacoes
            );
        }
        Acervo::insert($acervos);
    }


    private static function generateAcervoData(
        $faker,
        $nomes,
        $autors,
        $editoras,
        $categorias,
        $tipos,
        $estados,
        $situacoes
    ) {
        $tipo = $tipos->random();
        $ibns = ($tipo == 1)
            ? $faker->unique()
            ->numerify('###-##-#####-##-#')
            : null;

        return [
            'titulo' => $nomes->random(),
            'subtitulo' => $faker->sentence(6),
            'resumo' => $faker->paragraph(3),
            'tradutor' => $faker->name,
            'autor_id' => $autors->random(),
            'idioma_id' => 1,
            'editora_id' => $editoras->random(),
            'categoria_id' => $categorias->random(),
            'tipo_id' => $tipo,
            'estado_id' => $estados->random(),
            'situacao_id' => $situacoes->random(),
            'IBNS' => $ibns,
            'ano_publicacao' => self::getBirthYear($faker, 1, 100),
            'capa' => self::getAcervoCapa($tipo),
            'edicao' => $faker->randomDigit() . 'º edição',
            'data_aquisicao' => $faker->dateTimeBetween('-20 years', 'now')
                ->format('Y-m-d'),
        ];
    }



    public static function attributeAcervoAreas()
    {

        Acervo::orderBy('id')->chunk(100, function (Collection $acervos) {
            $acervo_areas = [];
            foreach ($acervos as $acervo) {
                foreach (AreaConhecimento::where('nome', $acervo->titulo)->first()->getRelatedAreas() as $area) {
                    $acervo_areas[] = [
                        'area_codigo' => $area->codigo,
                        'model_id' => $acervo->id,
                        'model_type' => Acervo::class,
                    ];
                }
            }
            DB::table('model_has_areas')->insert($acervo_areas);
        });
    }


    private static function createEmprestimo($aluno, $faker, $bibliotecarios)
    {
        $ano = 1;
        for ($j = $aluno->aluno->periodo_id; $j > 0; $j--) {
            $ano_fim = $ano - 1;
            for ($i = 0; $i < $faker->randomDigit(); $i++) {
                $data_emprestimo = $faker->dateTimeBetween("-$ano years", "-$ano_fim years");
                $data_devolucao = $faker->dateTimeBetween($data_emprestimo, (clone $data_emprestimo)->modify('+30 days'));
                $acervo = Acervo::inRandomOrder()->first();

                $emprestimo = Emprestimo::create([
                    'acervo_id' => $acervo->id,
                    'bibliotecario_id' => $bibliotecarios->random(),
                    'leitor_id' => $aluno->id,
                    'data_emprestimo' => $data_emprestimo,
                    'data_devolucao' => $data_devolucao,
                    'created_at' => $data_emprestimo,
                    'updated_at' => $data_devolucao,
                ]);

                $aluno->aluno->AttributeAlunoAreaByAcervo($acervo);

                $interval = $data_devolucao->diff($data_emprestimo);
                $daysInterval = $interval->days;

                if ($daysInterval > 14) {
                    $valor_multa = $acervo->tipo->multa * ($daysInterval - 14);

                    $multa = Multa::create([
                        'pessoa_id' => $aluno->id,
                        'multa_type' => Emprestimo::class,
                        'multa_id' => $emprestimo->id,
                        'mensagem' => config('mensagens.devolucao_de_acervo_atrasado'),
                        'dias_atrasados' => ($daysInterval - 14),
                        'valor' => $valor_multa,
                        'pago' => $data_devolucao,
                    ]);
                }
            }
            $ano++;
        }
    }


    private static function generateEmprestimos()
    {
        echo 'generateEmprestimos' . PHP_EOL;

        $blibliotecarios = Pessoa::role('Bibliotecário')->pluck('id');
        $faker = \Faker\Factory::create('pt_BR');

        Pessoa::role('Aluno')
            ->orderBy('id')
            ->chunk(200, function (Collection $alunos) use ($blibliotecarios, $faker) {
                foreach ($alunos as $aluno) {
                    self::createEmprestimo($aluno, $faker, $blibliotecarios);
                }
            });
    }
}
