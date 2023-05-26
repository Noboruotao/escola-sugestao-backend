<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\Aluno;
use App\Models\Pessoa;
use App\Models\Curso;


class PessoaCursoFactory extends customFactory
{
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
        echo "    start inserirCursos()". PHP_EOL;
        $cursos = [
            [
                'nome' => 'Administração',
                'descricao' => 'Forma profissionais para gerenciamento de organizações, setores ou departamentos de empresas.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Arquitetura e Urbanismo',
                'descricao' => 'Estuda a concepção e construção de espaços urbanos, edifícios e paisagens.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Biologia',
                'descricao' => 'Curso que estuda os seres vivos, desde a sua estrutura até suas relações com o meio ambiente.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Ciências Contábeis',
                'descricao' => 'Forma profissionais especializados em controlar e analisar as finanças de empresas, organizações e governos.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Direito',
                'descricao' => 'Estuda as leis e normas jurídicas, e forma profissionais aptos para atuar como advogados, juízes, promotores, entre outros.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Economia',
                'descricao' => 'Curso que estuda as relações de produção, distribuição e consumo de bens e serviços.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Educação Física',
                'descricao' => 'Estuda o corpo humano, a prática de exercícios físicos e esportes, e forma profissionais para atuar como professores, treinadores, entre outros.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Engenharia Civil',
                'descricao' => 'Estuda a construção de edifícios, rodovias, pontes, entre outros, e forma profissionais para projetar e gerenciar essas obras.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Engenharia de Computação',
                'descricao' => 'Estuda a concepção e desenvolvimento de sistemas computacionais, hardware e software, e forma profissionais para trabalhar em áreas de tecnologia.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Engenharia Elétrica',
                'descricao' => 'Estuda a geração, transmissão e distribuição de energia elétrica, além de sistemas eletrônicos e de automação, e forma profissionais para projetar e gerenciar essas áreas.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Engenharia Mecânica',
                'descricao' => 'Estuda máquinas, motores, equipamentos e sistemas mecânicos, e forma profissionais para projetar e gerenciar essas áreas.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Enfermagem',
                'descricao' => 'Estuda a prevenção e tratamento de doenças, e forma profissionais para atuar como enfermeiros em hospitais, clínicas, unidades de saúde, entre outros.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Farmácia',
                'descricao' => 'Estuda medicamentos, fármacos, cosméticos e alimentos, e forma profissionais para atuar em farmácias, indústrias farmacêuticas, laboratórios, entre outros.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Fisioterapia',
                'descricao' => 'Estuda a reabilitação física, prevenção de lesões e tratamento de doenças relacionadas ao corpo humano, e forma profissionais para atuar em clínicas, hospitais, unidades de saúde, entre outros.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Jornalismo',
                'descricao' => 'Curso que forma profissionais para atuar no mercado jornalístico, produzindo conteúdos para diversos meios de comunicação, como jornais, revistas, TV, rádio e internet.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Medicina',
                'descricao' => 'Curso que forma médicos capacitados a diagnosticar e tratar doenças e lesões em seres humanos.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Nutrição',
                'descricao' => 'Curso que forma nutricionistas para planejar, supervisionar e avaliar dietas para indivíduos e coletividades.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Odontologia',
                'descricao' => 'Curso que forma dentistas capacitados a diagnosticar e tratar doenças e lesões na cavidade bucal.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Psicologia',
                'descricao' => 'Curso que forma psicólogos para diagnosticar e tratar distúrbios mentais e emocionais, além de estudar o comportamento humano.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Publicidade e Propaganda',
                'descricao' => 'Curso que forma profissionais para atuar no mercado publicitário, planejando, criando e divulgando campanhas publicitárias para produtos, marcas e serviços.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Química',
                'descricao' => 'Curso que forma químicos capacitados a desenvolver e aperfeiçoar processos químicos e produtos para diversos fins.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Relações Internacionais',
                'descricao' => 'Curso que forma profissionais capazes de analisar as relações entre países, organizações e empresas internacionais, buscando soluções para problemas globais.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Serviço Social',
                'descricao' => 'Curso que forma assistentes sociais para atuar no planejamento e execução de políticas públicas e de ações sociais para pessoas e grupos em situação de vulnerabilidade.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
            [
                'nome' => 'Veterinária',
                'descricao' => 'Curso que forma médicos veterinários capacitados a diagnosticar e tratar doenças em animais, além de promover a saúde e o bem-estar animal.',
                'created_at'=>now(),
                'updated_at'=>now()
            ],
        ];
        $this->verifyTable('cursos', $cursos);
    }


    /**
     * manda array para customFactory::insertDatas()
     * @return array
     */
    protected function insertBolsas()
    {
        echo "    start insertBolsas()". PHP_EOL;
        $bolsas = [
            ['nome' => 'Bolsa de estudo para alunos de escolas públicas',
            'valor' =>300],
            ['nome' => 'Bolsa Atleta',
            'valor' =>800],
            ['nome' => 'Bolsa Família',
            'valor' =>800],
            ['nome' => 'Bolsa de estudo para filhos de funcionários de empresas',
            'valor' =>300],
            ['nome' => 'Bolsa de estudo para filhos de militares',
            'valor' =>300],
            ['nome' => 'Bolsa de estudo para alunos de baixa renda',
            'valor' =>800],
            ['nome' => 'Bolsa de estudo para alunos com deficiência',
            'valor' =>500],
            ['nome' => 'Bolsa de estudo para alunos indígenas',
            'valor' =>500],
            
        ];
        $this->verifyTable('bolsas', $bolsas);
    }


    /**
     * manda array para customFactory::insertDatas()
     * @return array
     */
    protected function inserirSituacaoAluno()
    {
        echo "    start inserirSituacaoAluno()". PHP_EOL;
        $situacao = [
            ['situacao'=>'Matriculado'],
            ['situacao'=>'Formado'],
            ['situacao'=>'Trancado'],
            ['situacao'=>'Jubilado'],
            ['situacao'=>'Desistente'],
            ['situacao'=>'Concluído'],
            ['situacao'=>'Requerente'],
            ['situacao'=>'Afastado'],
            ['situacao'=>'Transferido'],
            ['situacao'=>'Cancelado'],
            ['situacao'=>'Em Andamento'],
        ];
        $this->verifyTable('situacao_aluno', $situacao);
    }


    /**
     * manda array para customFactory::insertDatas()
     * @return array
     */
    protected function insertNivelEscolar()
    {
        echo "    start insertNivelEscolar()". PHP_EOL;
        $nivel_escolar = [
            ['nome' => 'Ensino Infantil'],
            ['nome' => 'Ensino Fundamental'],
            ['nome' => 'Ensino Médio'],
            ['nome' => 'Cursos Técnicos'],
            ['nome' => 'Cursos Preparatórios'],
        ];
        $this->verifyTable('nivel_escolar', $nivel_escolar);
    }


    /**
     * manda array para customFactory::insertDatas()
     * @return array
     */
    protected function insertAno()
    {
        echo "    start insertAno()". PHP_EOL;
        foreach([['Ensino Infantil', 5], ['Ensino Fundamental',9], ['Ensino Médio', 3],['Cursos Técnicos', 3], ['Cursos Preparatórios', 1]] as $nivel)
        {
            for($i=1; $i<=$nivel[1]; $i++)
            {
                $data[] = [
                    'nivel_escolar_id'=> DB::table('nivel_escolar')->where('nome', $nivel[0])->first()->id,
                    'ano'=> $i
                ];
            }
        }
        $this->verifyTable('anos', $data);
    }


    protected function verifyIfValueExists($coluna, callable $callback, $current_datas)
    {
        do {
            $value = $callback();

            if (Pessoa::where($coluna, $value)->exists() || $current_datas->contains($coluna, $value) ) {
                $value = null;
            }
        } while ($value == null);

        return $value;
    }


    /**
     * manda array para customFactory::insertDatas()
     * @int $numero_de_pessoas
     * @return array
     */
    protected function makePessoa($numero_de_pessoa)
    {
        echo "    start makePessoa()". PHP_EOL;
        $pessoas = collect();

        try {
            while($numero_de_pessoa>0)
            {
                $genero = $this->faker->randomElement(['Masculino', 'Feminino']);

                $data_nascimento = $this->faker->dateTimeBetween('-'.$this->faker->biasedNumberBetween(2, 50, function($x) {
                    return 18 - $x;
                }).' years', '-1 years')->format('Y-m-d');

                $idade = $this->getIdade($data_nascimento);

                if($genero == 'Masculino')
                {
                    $prim_nome = $this->faker->firstNameMale();

                    if($idade < 10){
                        $foto = 'images/pessoas_foto/boy_'.$this->faker->randomElement(['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12']).'.png';
                    }else if($idade < 18){
                        $foto = 'images/pessoas_foto/youngman_'.$this->faker->randomElement(['25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36']).'.png';
                    }else{
                        $foto = 'images/pessoas_foto/man_'.$this->faker->randomElement(['49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59', '60']).'.png';
                    }
                }else{
                    $prim_nome = $this->faker->firstNameFemale();

                    if($idade < 10){
                        $foto = 'images/pessoas_foto/girl_'.$this->faker->randomElement(['13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24']).'.png';
                    }else if($idade < 18){
                        $foto = 'images/pessoas_foto/youngwoman_'.$this->faker->randomElement(['37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48']).'.png';
                    }else{
                        $foto = 'images/pessoas_foto/woman_'.$this->faker->randomElement(['61', '62', '63', '64', '65', '66', '67', '68', '69', '70', '71', '72']).'.png';
                    }
                }

                $cpf = $this->verifyIfValueExists('cpf', function(){
                    return $this->faker->cpf();
                }, $pessoas);
            
                $rg = $this->verifyIfValueExists('rg', function(){
                    return $this->faker->rg();
                }, $pessoas);

                do {
                    $email = $prim_nome . $this->faker->numerify('####') . '.' . $this->faker->email();
                
                    if (Pessoa::where('email', $email)->exists() == true || $pessoas->contains('email', $email) == true) {
                        $email = null;
                    }
                } while ($email === null);
                

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
                    'telefone' => (rand(0, 1))? $this->faker->landline(): null,
                    'celular' => (rand(0, 1))? $this->faker->cellphone(): null,
                    'senha' => \Illuminate\Support\Facades\Hash::make('password'),
                    'foto'=> $foto,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);

                $numero_de_pessoa--;
                
                if($pessoas->count()>=200)
               {
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
        echo "    start makeProfessor()". PHP_EOL;
        $cursos = Curso::all();

        $limit = ceil(Pessoa::whereRaw('DATEDIFF(CURDATE(), data_de_nascimento) / 365 > 18')->count() / 10);

        Pessoa::whereRaw('DATEDIFF(CURDATE(), data_de_nascimento) / 365 > 18')->limit($limit)->orderBy('id')->chunk(500, function (Collection $professors) use ($cursos){
            foreach($professors as $professor)
            {
                $curso = $cursos->random();

                $curso_professor[] = ['professor_id'=>$professor->id, 'curso_id'=>$curso->id];

                $datas[] = [
                    'id' =>$professor->id,
                    'experiencia_profissional' => 'Tem experiência em '. $this->faker->randomElement(['lecionar ', 'estudar ', 'pesquisar ']). 'na área de '.$curso->nome.' por '.($this->faker->numberBetween(1, $this->getIdade($professor->data_de_nascimento)-18)).' anos',
                ];

                if(count($datas)>200)
               {
                $this->insertDatas('professors', $datas);
                }
                
                if(count($curso_professor)>200)
               {
                $this->insertDatas('curso_professor', $curso_professor);
                };
            }
        });
        $this->insertDatas('professors', $datas);
        $this->insertDatas('curso_professor', $curso_professor);
    }


    protected function makeAluno()
    {
        echo "    start makeAluno()". PHP_EOL;
        $anos = \App\Models\Ano::all();
        Pessoa::whereRaw('DATEDIFF(CURDATE(), data_de_nascimento) / 365 < 18')->orderBy('id')->chunk(500, function (Collection $alunos) use ($anos) {

            foreach($alunos as $aluno)
            {
                $idade = $this->getIdade($aluno->data_de_nascimento);
                
                $datas[] = [
                    'id' => $aluno->id,
                    'ano_id' => $anos->where('id', $idade)->first()->id,
                    'situacao_id' => $this->faker->randomElement([1, 3, 11])
                ];

            }

            if(count($datas)>200)
           {
            $this->insertDatas('alunos', $datas);
            };

        });
        $this->insertDatas('alunos', $datas);
        $this->attributeBolsa();
    }


    protected function attributeBolsa()
    {
        $alunos = Aluno::all();

        Aluno::orderBy('id')->chunk(500, function (Collection $alunos) {

            foreach($alunos as $aluno)
            {
                if(rand(0, 2)==1)
                {
                    $datas[] = [
                        'aluno_id'=> $aluno->id,
                        'bolsa_id'=> DB::table('bolsas')->inRandomOrder()->first()->id
                    ];
                }
            }

            if(count($datas)>200)
           {
            $this->insertDatas('aluno_bolsa', $datas);
            };
        });
        $this->insertDatas('aluno_bolsa', $datas);
    }    


    protected function makePais()
    {
        echo "    start makePais()". PHP_EOL;
        $adultos = Pessoa::whereRaw('DATEDIFF(CURDATE(), data_de_nascimento) / 365 > 18')->pluck('id')->toArray();
        Aluno::orderBy('id')->chunk(500, function (Collection $alunos) use ($adultos){

            foreach($alunos as $aluno)
            {
                foreach( $this->faker->randomElements($adultos, $count = rand(1, 2) ) as $pai )
                {
                    $datas[] = [
                        'pais_ou_responsavel_id' => $pai,
                        'aluno_id' => $aluno->id,
                    ];
                }

            }

            if(count($datas)>200)
           {
            $this->insertDatas('pais_ou_responsaveis', $datas);
            };

        });
        $this->insertDatas('pais_ou_responsaveis', $datas);
    }


    protected function insertMensalidade()
    {
        echo "    start insertMensalidade()". PHP_EOL;
        Aluno::orderBy('id')->chunk(500, function (Collection $alunos) {

            foreach($alunos as $aluno)
            {
                $datas[] = [
                    'aluno_id'=> $aluno->id,
                    'valor'=> \App\Models\Bolsa::getValorMensalidade($id=$aluno->id)
                ];
            }

            if(count($datas)>200)
           {
            $this->insertDatas('mensalidades', $datas);
            };
        });
        $this->insertDatas('mensalidades', $datas);
    }
}
