<?php

namespace Database\Factories;

use App\Models\Acervo;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Autor;
use App\Models\Idioma;
use App\Models\Categoria;
use App\Models\AcervoTipo;
use App\Models\AcervoEstado;
use App\Models\AcervoSituacao;
use App\Models\Nacionalidade;
use App\Models\Editora;

class AcervoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
    }


    protected static function getBirthYear($faker, $max = 25, $min = 1000)
    {
        $maxBirthYear = now()->subYears($max)->year;
        return $faker->numberBetween($maxBirthYear - $min, $maxBirthYear);
    }


    protected static function getDeathYear($faker, $ano_nascimento, $minLifespan = 20, $maxLifespan = 100)
    {
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

            $ano_nascimento = AcervoFactory::getBirthYear($faker, 25, 1000);
            $ano_falecimento = AcervoFactory::getDeathYear($faker, $ano_nascimento, 20, 100);

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
                'cnpj' => $faker->unique()->numerify('##.###.###/####-##'),
                'endereco_id' => $endereco->id,
            ];
        }
        Editora::insert($editoras);
    }


    protected static function getAcervoCapa($tipo)
    {
        if ($tipo == 4) {
            return config('seeder_datas.acervoCapa.4');
        } else if ($tipo == 6) {
            return config('seeder_datas.acervoCapa.6');
        } else if ($tipo == 7) {
            return config('seeder_datas.acervoCapa.7');
        } else {
            return config('seeder_datas.acervoCapa.1');
        }
    }


    public static function createAcervo($num = 500)
    {
        $autors = Autor::pluck('id');
        $editoras = Editora::pluck('id');
        $categorias = Categoria::pluck('id');
        $tipos = AcervoTipo::pluck('id');
        $estados = AcervoEstado::pluck('id');
        $situacoes = AcervoSituacao::pluck('id');

        $nomes = \App\Models\AreaConhecimento::pluck('nome');

        $faker = \Faker\Factory::create('pt_BR');

        for ($i = 0; $i < $num; $i++) {
            $tipo = $tipos->random();
            $ibns = ($tipo == 1) ?
                $faker->unique()->numerify('###-##-#####-##-#')
                : null;
            $acervos[] = [
                'titulo' => $nomes->random(),
                'subtitulo' =>  $faker->sentence(6),
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
                'ano_de_publicacao' => AcervoFactory::getBirthYear($faker, 1, 100),
                'capa' => AcervoFactory::getAcervoCapa($tipo),
                'edicao' => $faker->randomDigit() . 'º edição',
                'data_aquisicao' => $faker->dateTimeBetween('-20 years', 'now')->format('Y-m-d'),
            ];
        }
        Acervo::insert($acervos);
    }
}
