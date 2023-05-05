<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AcervoFactory extends customFactory
{
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
     * para verifyTable()customFactory
     */
    protected function insertTipoAcervo()
    {
        echo "    start insertTipoAcervo()". PHP_EOL;
        $tipos_acervo = [
                    ['tipo'=>'Livro', 'multa'=>0.6],
                    ['tipo'=>'Periódicos', 'multa'=>0.6],
                    ['tipo'=>'Teses e Dissertações', 'multa'=>0.8],
                    ['tipo'=>'CD e DVD', 'multa'=>0.8],
                    ['tipo'=>'Mapas e Atlas', 'multa'=>0.6],
                    ['tipo'=>'Arquivos Digitais', 'multa'=>0.7],
                    ['tipo'=>'Acervo Infantil', 'multa'=>0.4],
                    ['tipo'=>'Acervo de Referência', 'multa'=>0.6],
                    ['tipo'=>'Coleções Especiais', 'multa'=>0.6]
                ];
        $this->verifyTable('tipo_de_acervo', $tipos_acervo);
    }


    /**
     * manda o array com os dados do estado 
     * do acervo para verifyTable()customFactory
     */
    protected function insertEstadoAcervo()
    {
        echo "    start insertEstadoAcervo()". PHP_EOL;
        $estados_acervo = [
            ['estado'=>'Bom'],
            ['estado'=>'Ótimo'],
            ['estado'=>'Falta Páginas'],
            ['estado'=>'Capa está Ruim'],
            ['estado'=>'Descartado'],
            ['estado'=>'Extraviado'],
            ['estado'=>'Debuiado'],
        ];

        $this->verifyTable('estado_do_acervo', $estados_acervo);
    }


    /**
     * manda o array com os dados da situação 
     * do acervo para verifyTable()customFactory
     */
    protected function insertSituacaoAcervo()
    {
        echo "    start insertSituacaoAcervo()". PHP_EOL;
        $situacao_acervo = [
            ['situacao'=>'Disponível'],
            ['situacao'=>'Emprestado'],
            ['situacao'=>'Reservado'],
            ['situacao'=>'Em Processamento Técnico'],
            ['situacao'=>'Em Manutanção'],
            ['situacao'=>'Extraviado'],
            ['situacao'=>'Descartado'],
        ];
        $this->verifyTable('situacao_do_acervo', $situacao_acervo);
    }  
    
    
    /**
     * manda o array com os dados da categoria 
     * do acervo para verifyTable()customFactory
     */
    protected function insertCategoriaAcervo()
    {
        echo "    start insertCategoriaAcervo()". PHP_EOL;
        $categorias_acervo = [
            ['categoria' => 'Ação e Aventura'],
            ['categoria' => 'Arte e Música'],
            ['categoria' => 'Autoajuda'],
            ['categoria' => 'Biografias e Memórias'],
            ['categoria' => 'Ciência e Tecnologia'],
            ['categoria' => 'Clássicos'],
            ['categoria' => 'Comics e Mangás'],
            ['categoria' => 'Contos e Crônicas'],
            ['categoria' => 'Educação e Didáticos'],
            ['categoria' => 'Esoterismo'],
            ['categoria' => 'Esportes e Lazer'],
            ['categoria' => 'Ficção Científica e Fantasia'],
            ['categoria' => 'Filosofia'],
            ['categoria' => 'História do Brasil'],
            ['categoria' => 'História Geral'],
            ['categoria' => 'Horror e Suspense'],
            ['categoria' => 'Humor'],
            ['categoria' => 'Infantojuvenis'],
            ['categoria' => 'Literatura Brasileira'],
            ['categoria' => 'Literatura Estrangeira'],
            ['categoria' => 'Medicina e Saúde'],
            ['categoria' => 'Negócios e Economia'],
            ['categoria' => 'Poesia'],
            ['categoria' => 'Policial e Mistério'],
            ['categoria' => 'Política'],
            ['categoria' => 'Psicologia'],
            ['categoria' => 'Religião e Espiritualidade'],
            ['categoria' => 'Romance'],
            ['categoria' => 'Terror'],
            ['categoria' => 'Viagem'],
        ];
        $this->verifyTable('categorias', $categorias_acervo);
    }


    /**
     * manda o array com os dados de idiomas
     * para a função customFactory::verifyTable
     */
    protected function insertIdiomas()
    {
        echo "    start insertIdiomas()". PHP_EOL;
        $idiomas = [
            ['idioma' => 'Português'],
            ['idioma' => 'Inglês'],
            ['idioma' => 'Espanhol'],
            ['idioma' => 'Francês'],
            ['idioma' => 'Alemão'],
            ['idioma' => 'Italiano'],
            ['idioma' => 'Japonês'],
            ['idioma' => 'Mandarim'],
            ['idioma' => 'Coreano'],
            ['idioma' => 'Russo'],
            ['idioma' => 'Árabe'],
            ['idioma' => 'Hebraico'],
            ['idioma' => 'Grego'],
            ['idioma' => 'Latim']
        ];
        $this->verifyTable('idiomas', $idiomas);

        echo "    start insertNacionalidades()". PHP_EOL;
        $nacionalidades = [
            ['nacionalidade' => 'Brasil', 
            'idioma_oficial_id' => array_search(['idioma'=>'Português'], $idiomas)+1],
            ['nacionalidade' => 'Portugal', 
            'idioma_oficial_id' => array_search(['idioma'=>'Português'], $idiomas)+1],
            ['nacionalidade' => 'Estados Unidos', 
            'idioma_oficial_id' => array_search(['idioma'=>'Inglês'], $idiomas)+1],
            ['nacionalidade' => 'Espanha', 
            'idioma_oficial_id' => array_search(['idioma'=>'Espanhol'], $idiomas)+1],
            ['nacionalidade' => 'França', 
            'idioma_oficial_id' => array_search(['idioma'=>'Francês'], $idiomas)+1],
            ['nacionalidade' => 'Alemanha', 
            'idioma_oficial_id' => array_search(['idioma'=>'Alemão'], $idiomas)+1],
            ['nacionalidade' => 'Itália', 
            'idioma_oficial_id' => array_search(['idioma'=>'Italiano'], $idiomas)+1],
            ['nacionalidade' => 'Japão', 
            'idioma_oficial_id' => array_search(['idioma'=>'Japonês'], $idiomas)+1],
            ['nacionalidade' => 'China', 
            'idioma_oficial_id' => array_search(['idioma'=>'Mandarim'], $idiomas)+1],
            ['nacionalidade' => 'Coreia do Sul', 
            'idioma_oficial_id' => array_search(['idioma'=>'Coreano'], $idiomas)+1],
            ['nacionalidade' => 'Rússia', 
            'idioma_oficial_id' => array_search(['idioma'=>'Russo'], $idiomas)+1],
            ['nacionalidade' => 'Emirados Árabes Unidos', 
            'idioma_oficial_id' => array_search(['idioma'=>'Árabe'], $idiomas)+1],
            ['nacionalidade' => 'Israel', 
            'idioma_oficial_id' => array_search(['idioma'=>'Hebraico'], $idiomas)+1],
            ['nacionalidade' => 'Grécia', 
            'idioma_oficial_id' => array_search(['idioma'=>'Grego'], $idiomas)+1],
            ['nacionalidade' => 'Vaticano', 
            'idioma_oficial_id' => array_search(['idioma'=>'Latim'], $idiomas)+1],
        ];

        $this->verifyTable('nacionalidades', $nacionalidades);
    }


    /**
     * manda o array com os dados dos Estados Brasileiros
     * para a função customFactory::verifyTable
     */
    protected function insertEstados()
    {
        echo "    start insertEstados()". PHP_EOL;
        $estados = [
            ['estado' => 'Acre', 'sigla' => 'AC'],
            ['estado' => 'Alagoas', 'sigla' => 'AL'],
            ['estado' => 'Amapá', 'sigla' => 'AP'],
            ['estado' => 'Amazonas', 'sigla' => 'AM'],
            ['estado' => 'Bahia', 'sigla' => 'BA'],
            ['estado' => 'Ceará', 'sigla' => 'CE'],
            ['estado' => 'Distrito Federal', 'sigla' => 'DF'],
            ['estado' => 'Espírito Santo', 'sigla' => 'ES'],
            ['estado' => 'Goiás', 'sigla' => 'GO'],
            ['estado' => 'Maranhão', 'sigla' => 'MA'],
            ['estado' => 'Mato Grosso', 'sigla' => 'MT'],
            ['estado' => 'Mato Grosso do Sul', 'sigla' => 'MS'],
            ['estado' => 'Minas Gerais', 'sigla' => 'MG'],
            ['estado' => 'Pará', 'sigla' => 'PA'],
            ['estado' => 'Paraíba', 'sigla' => 'PB'],
            ['estado' => 'Paraná', 'sigla' => 'PR'],
            ['estado' => 'Pernambuco', 'sigla' => 'PE'],
            ['estado' => 'Piauí', 'sigla' => 'PI'],
            ['estado' => 'Rio de Janeiro', 'sigla' => 'RJ'],
            ['estado' => 'Rio Grande do Norte', 'sigla' => 'RN'],
            ['estado' => 'Rio Grande do Sul', 'sigla' => 'RS'],
            ['estado' => 'Rondônia', 'sigla' => 'RO'],
            ['estado' => 'Roraima', 'sigla' => 'RR'],
            ['estado' => 'Santa Catarina', 'sigla' => 'SC'],
            ['estado' => 'São Paulo', 'sigla' => 'SP'],
            ['estado' => 'Sergipe', 'sigla' => 'SE'],
            ['estado' => 'Tocantins', 'sigla' => 'TO'],
        ];
        $this->verifyTable('estados', $estados);
    }


    /**
     * manda o array com os dados de editoras
     * para a função customFactory::verifyTable
     */
    protected function insertEditoras($numero_de_editoras=10)
    {
        echo "    start insertEditoras()". PHP_EOL;
        $editoras = [];
        while($numero_de_editoras > 0)
        {
            $editoras[] = [
                    'nome'=>$this->faker->company(),
                    'email'=>$this->faker->safeEmail(),
                    'telefone'=>$this->faker->phoneNumber(),
                    'endereco'=>$this->faker->address(),
                    'cnpj'=>$this->faker->cnpj(),
                    'cidade'=>$this->faker->city(),
                    'cep'=>$this->faker->postcode(),
                    'estado_id'=>DB::table('estados')->inRandomOrder()->first()->id
            ];
            $numero_de_editoras--;
        }
        $this->insertDatas('editoras', $editoras);
    }


    /**
     * manda o array com os dados de autores
     * para a função customFactory::verifyTable
     */
    protected function insertAutores($numero_de_autores=10)
    {
        echo "    start insertAutores()". PHP_EOL;

        $autores = $this->makeAutores($numero_de_autores);
        $this->insertDatas('autores', $autores);

    }


    /**
     * retorna o locale para o faker
     * @return string
     */
    protected function getLocale($nacionalidade)
    {
        if($nacionalidade==1){
            return 'pt_BR';
        }else if($nacionalidade==2){
            return 'pt_PT';
        }else if($nacionalidade==3){
            return 'en_US';
        }else if($nacionalidade==4){
            return 'es_ES';
        }else if($nacionalidade==5){
            return 'fr_FR';
        }else if($nacionalidade==6){
            return 'de_DE';
        }else if($nacionalidade==7){
            return 'it_IT';
        }else if($nacionalidade==8){
            return 'ja_JP';
        }else if($nacionalidade==9){
            return 'zh_CN';
        }else if($nacionalidade==10){
            return 'ko_KR';
        }else if($nacionalidade==11){
            return 'ru_RU';
        }else if($nacionalidade==12){
            return 'ar_SA';
        }else if($nacionalidade==13){
            return 'he_IL';
        }else if($nacionalidade==14){
            return 'el_GR';
        }else if($nacionalidade==15){
            return 'en_US';
        };
    }


    /**
     * retorn um array para a função $this->insertAutores
     * @return array
     */
    protected function makeAutores($numero_de_autores)
    {
        $autores = [];
        while($numero_de_autores > 0)
        {
            $nacionalidade = DB::table('nacionalidades')->inRandomOrder()->first()->id;
            $faker = \Faker\Factory::create( $this->getLocale($nacionalidade) );
            $data_de_nascimento = $faker->dateTimeBetween('-90 years', '-18 years')->format('Y-m-d');

            $autores[] = [
                'nome' => Str::transliterate ($faker->name),
                'nacionalidade_id' => $nacionalidade,
                'data_de_nascimento' => $data_de_nascimento,
                'data_de_falecimento' => (rand(0, 1) ===1)?$faker->dateTimeBetween($data_de_nascimento, 'now')->format('Y-m-d'): null
            ];

            $numero_de_autores--;
        }
        return $autores;
    }


    /**
     * manda array para a função customFactory::insertDatas()
     */
    protected function insertAcervo($numero_de_acervos=10)
    {
        echo "    start insertAcervo()". PHP_EOL;
        $acervos = $this->makeAcervo($numero_de_acervos);
        $this->insertDatas('acervos', $acervos);
    }


    /**
     * retorna arrays para $this->isnertAcervo()
     * @return array
     */
    protected function makeAcervo($numero_de_acervos)
    {
        $acervos =[];
        $tipos_acervo_qnt = DB::table('tipo_de_acervo')->count();

        while($numero_de_acervos>0)
        {
            $tipo_acervo = $this->faker->biasedNumberBetween(1, $tipos_acervo_qnt, function($x) {
                return 11 - $x;
            });

            $acervos[] = [
                'titulo' => $this->faker->sentence($nbWords = 4, $variableNbWords = true),
                'resumo' => $this->faker->paragraph(3),
                'tradutor' => $this->faker->name(),
                'autor_id' =>   DB::table('autores')->inRandomOrder()->first()->id,
                'idiomas_id' => DB::table('idiomas')->inRandomOrder()->first()->id,
                'editora_id' => DB::table('editoras')->inRandomOrder()->first()->id,
                'categoria_id' => DB::table('categorias')->inRandomOrder()->first()->id,
                'tipo_id' => $tipo_acervo,
                'estado_id' => DB::table('estado_do_acervo')->inRandomOrder()->first()->id,
                'situacao_id' => DB::table('situacao_do_acervo')->inRandomOrder()->first()->id,
                'IBNS' => ($tipo_acervo==1)? $this->faker->numerify('###-#-##-######-#'): NULL,
                'ano_de_publicacao' => $this->faker->date($format='Y', $max='now'),
                'created_at'=>now(),
                'updated_at'=>now()
            ];
            $numero_de_acervos--;
        }
        return $acervos;
    }
}
