<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\models\TipoAcervo;
use App\models\Autor;
use App\models\Estado;

use App\models\Idioma;
use App\models\Editora;
use App\models\Categoria;

use App\models\EstadoAcervo;
use App\models\SituacaoAcervo;
use App\models\Nacionalidade;

class AcervoFactory extends customFactory
{

    protected array $seederDatas;
    protected $faker;

    public function __construct()
    {
        $this->seederDatas = config('seeder_datas.acervoSeederData');
        $this->faker = \Faker\Factory::create('pt_BR');
    }

    /**
     * $num_editoras: numero de Editoras para 
     */
    public function definition($num_editoras = 50, $num_autores = 150, $num_acervos = 500)
    {
        dump('Starting Acervo seeding');
        $acervoSeeder = new AcervoFactory();

        $acervoSeeder->insertTipoAcervo();
        $acervoSeeder->insertEstadoAcervo();
        $acervoSeeder->insertSituacaoAcervo();

        $acervoSeeder->insertCategoriaAcervo();
        $acervoSeeder->insertIdiomas();
        $acervoSeeder->insertEstados();

        $acervoSeeder->insertEditoras($num_editoras);
        $acervoSeeder->insertAutores($num_autores);
        $acervoSeeder->insertAcervo($num_acervos);
    }


    /**
     * manda a array com os dados do tipo de acervo 
     * para insertDatas()customFactory
     */
    protected function insertTipoAcervo()
    {
        echo "    start insertTipoAcervo()" . PHP_EOL;
        $this->verifyTable('tipo_de_acervo', $this->seederDatas['tipos_acervo']);
    }


    /**
     * manda o array com os dados do estado 
     * do acervo para insertDatas()customFactory
     */
    protected function insertEstadoAcervo()
    {
        echo "    start insertEstadoAcervo()" . PHP_EOL;
        $this->verifyTable('estado_do_acervo', $this->seederDatas['estados_acervo']);
    }


    /**
     * manda o array com os dados da situação 
     * do acervo para insertDatas()customFactory
     */
    protected function insertSituacaoAcervo()
    {
        echo "    start insertSituacaoAcervo()" . PHP_EOL;
        $this->verifyTable('situacao_do_acervo', $this->seederDatas['situacao_acervo']);
    }


    /**
     * manda o array com os dados da categoria 
     * do acervo para insertDatas()customFactory
     */
    protected function insertCategoriaAcervo()
    {
        echo "    start insertCategoriaAcervo()" . PHP_EOL;
        $this->verifyTable('categorias', $this->seederDatas['categorias_acervo']);
    }


    /**
     * manda o array com os dados de idiomas
     * para a função customFactory::insertDatas
     */
    protected function insertIdiomas()
    {
        echo "    start insertIdiomas()" . PHP_EOL;
        $this->verifyTable('idiomas', $this->seederDatas['idiomas']);

        echo "    start insertNacionalidades()" . PHP_EOL;
        $this->verifyTable('nacionalidades', $this->seederDatas['nacionalidade']);
    }


    /**
     * manda o array com os dados dos Estados Brasileiros
     * para a função customFactory::insertDatas
     */
    protected function insertEstados()
    {
        echo "    start insertEstados()" . PHP_EOL;
        $this->verifyTable('estados', $this->seederDatas['estados']);
    }


    /**
     * manda o array com os dados de editoras
     * para a função customFactory::insertDatas
     */
    protected function insertEditoras($numero_de_editoras = 10)
    {
        echo "    start insertEditoras()" . PHP_EOL;

        $estados = Estado::pluck('id');

        while ($numero_de_editoras > 0) {

            $editoras[] = [
                'nome' => $this->faker->company(),
                'email' => $this->faker->safeEmail(),
                'telefone' => $this->faker->phoneNumber(),
                'endereco' => $this->faker->address(),
                'cnpj' => $this->faker->cnpj(),
                'cidade' => $this->faker->city(),
                'cep' => $this->faker->postcode(),
                'estado_id' => $estados->random(),
            ];
            $numero_de_editoras--;

            if (count($editoras) >= 200) {
                $this->insertDatas('editoras', $editoras);
            }
        }
        $this->insertDatas('editoras', $editoras);
    }


    /**
     * manda o array com os dados de autores
     * para a função customFactory::insertDatas
     */
    protected function insertAutores($numero_de_autores = 10)
    {
        echo "    start insertAutores()" . PHP_EOL;

        $nacionalidades = Nacionalidade::pluck('id');
        while ($numero_de_autores > 0) {
            $nacionalidade = $nacionalidades->random();

            $autorFaker = \Faker\Factory::create($this->getLocale($nacionalidade));

            $data_de_nascimento = $this->faker->dateTimeBetween('-90 years', '-18 years')->format('Y-m-d');

            $autores[] = [
                'nome' => Str::transliterate($autorFaker->name),
                'nacionalidade_id' => $nacionalidade,
                'data_de_nascimento' => $data_de_nascimento,
                'data_de_falecimento' => (rand(0, 1) === 1) ? $this->faker->dateTimeBetween($data_de_nascimento, 'now')->format('Y-m-d') : null
            ];
            $numero_de_autores--;

            if (count($autores) >= 200) {
                $this->insertDatas('autors', $autores);
            }
        }
        $this->insertDatas('autors', $autores);
    }


    /**
     * retorna o locale para o faker
     * @return string
     */
    protected function getLocale($nacionalidade)
    {
        return $this->seederDatas['locale'][$nacionalidade];
    }


    /**
     * manda array para a função customFactory::insertDatas()
     */
    protected function insertAcervo($numero_de_acervos = 10)
    {
        echo "    start insertAcervo()" . PHP_EOL;
        $tipos_acervo_qnt = TipoAcervo::count();
        $autores = Autor::pluck('id');
        $idioma = Idioma::where('idioma', 'Português')->first()->value('id');
        $editoras = Editora::pluck('id');
        $categorias = Categoria::pluck('id');
        $estados = EstadoAcervo::pluck('id');
        $situacoes = SituacaoAcervo::pluck('id');

        while ($numero_de_acervos > 0) {
            $tipo_acervo = $this->faker->biasedNumberBetween(1, $tipos_acervo_qnt, function ($x) {
                return 11 - $x;
            });

            $acervoCapa = config('seeder_datas.acervoSeederData.acervoCapa');
            $capa = isset($acervoCapa[$tipo_acervo]) ? $acervoCapa[$tipo_acervo] : '';

            $acervos[] = [
                'titulo' => $this->faker->sentence($nbWords = 4, $variableNbWords = true),
                'resumo' => $this->faker->paragraph(3),
                'tradutor' => $this->faker->name(),
                'autor_id' =>   $autores->random(),
                'idioma_id' => $idioma,
                'editora_id' => $editoras->random(),
                'categoria_id' => $categorias->random(),
                'tipo_id' => $tipo_acervo,
                'estado_id' => $estados->random(),
                'situacao_id' => $situacoes->random(),
                'IBNS' => ($tipo_acervo == 1) ? $this->faker->numerify('###-#-##-######-#') : NULL,
                'ano_de_publicacao' => $this->faker->date($format = 'Y', $max = 'now'),
                'capa' => $capa,
                'created_at' => now(),
                'updated_at' => now()
            ];
            $numero_de_acervos--;

            if (count($acervos) >= 200) {
                $this->insertDatas('acervos', $acervos);
            }
        }
        $this->insertDatas('acervos', $acervos);
    }
}
