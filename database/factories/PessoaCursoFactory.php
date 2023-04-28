<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class PessoaCursoFactory extends customFactory
{
    
    public function definition()
    {
        $pessoa_curso = new PessoaCursoFactory();
        $pessoa_curso->inserirCursos();
        $pessoa_curso->insertBolsas();
        $pessoa_curso->inserirSituacaoAluno();
        $pessoa_curso->insertNivelEscolar();
        $pessoa_curso->insertAno();
        $pessoa_curso->makePessoa(4000);
    }


    /**
     * manda array para customFactory::verifyTable()
     * @return array
     */
    protected function inserirCursos()
    {
        $cursos = [
            [
                'nome' => 'Administração',
                'descricao' => 'Forma profissionais para gerenciamento de organizações, setores ou departamentos de empresas.'
            ],
            [
                'nome' => 'Arquitetura e Urbanismo',
                'descricao' => 'Estuda a concepção e construção de espaços urbanos, edifícios e paisagens.'
            ],
            [
                'nome' => 'Biologia',
                'descricao' => 'Curso que estuda os seres vivos, desde a sua estrutura até suas relações com o meio ambiente.'
            ],
            [
                'nome' => 'Ciências Contábeis',
                'descricao' => 'Forma profissionais especializados em controlar e analisar as finanças de empresas, organizações e governos.'
            ],
            [
                'nome' => 'Direito',
                'descricao' => 'Estuda as leis e normas jurídicas, e forma profissionais aptos para atuar como advogados, juízes, promotores, entre outros.'
            ],
            [
                'nome' => 'Economia',
                'descricao' => 'Curso que estuda as relações de produção, distribuição e consumo de bens e serviços.'
            ],
            [
                'nome' => 'Educação Física',
                'descricao' => 'Estuda o corpo humano, a prática de exercícios físicos e esportes, e forma profissionais para atuar como professores, treinadores, entre outros.'
            ],
            [
                'nome' => 'Engenharia Civil',
                'descricao' => 'Estuda a construção de edifícios, rodovias, pontes, entre outros, e forma profissionais para projetar e gerenciar essas obras.'
            ],
            [
                'nome' => 'Engenharia de Computação',
                'descricao' => 'Estuda a concepção e desenvolvimento de sistemas computacionais, hardware e software, e forma profissionais para trabalhar em áreas de tecnologia.'
            ],
            [
                'nome' => 'Engenharia Elétrica',
                'descricao' => 'Estuda a geração, transmissão e distribuição de energia elétrica, além de sistemas eletrônicos e de automação, e forma profissionais para projetar e gerenciar essas áreas.'
            ],
            [
                'nome' => 'Engenharia Mecânica',
                'descricao' => 'Estuda máquinas, motores, equipamentos e sistemas mecânicos, e forma profissionais para projetar e gerenciar essas áreas.'
            ],
            [
                'nome' => 'Enfermagem',
                'descricao' => 'Estuda a prevenção e tratamento de doenças, e forma profissionais para atuar como enfermeiros em hospitais, clínicas, unidades de saúde, entre outros.'
            ],
            [
                'nome' => 'Farmácia',
                'descricao' => 'Estuda medicamentos, fármacos, cosméticos e alimentos, e forma profissionais para atuar em farmácias, indústrias farmacêuticas, laboratórios, entre outros.'
            ],
            [
                'nome' => 'Fisioterapia',
                'descricao' => 'Estuda a reabilitação física, prevenção de lesões e tratamento de doenças relacionadas ao corpo humano, e forma profissionais para atuar em clínicas, hospitais, unidades de saúde, entre outros.'
            ],
            [
                'nome' => 'Jornalismo',
                'descricao' => 'Curso que forma profissionais para atuar no mercado jornalístico, produzindo conteúdos para diversos meios de comunicação, como jornais, revistas, TV, rádio e internet.'
            ],
            [
                'nome' => 'Medicina',
                'descricao' => 'Curso que forma médicos capacitados a diagnosticar e tratar doenças e lesões em seres humanos.'
            ],
            [
                'nome' => 'Nutrição',
                'descricao' => 'Curso que forma nutricionistas para planejar, supervisionar e avaliar dietas para indivíduos e coletividades.'
            ],
            [
                'nome' => 'Odontologia',
                'descricao' => 'Curso que forma dentistas capacitados a diagnosticar e tratar doenças e lesões na cavidade bucal.'
            ],
            [
                'nome' => 'Psicologia',
                'descricao' => 'Curso que forma psicólogos para diagnosticar e tratar distúrbios mentais e emocionais, além de estudar o comportamento humano.'
            ],
            [
                'nome' => 'Publicidade e Propaganda',
                'descricao' => 'Curso que forma profissionais para atuar no mercado publicitário, planejando, criando e divulgando campanhas publicitárias para produtos, marcas e serviços.'
            ],
            [
                'nome' => 'Química',
                'descricao' => 'Curso que forma químicos capacitados a desenvolver e aperfeiçoar processos químicos e produtos para diversos fins.'
            ],
            [
                'nome' => 'Relações Internacionais',
                'descricao' => 'Curso que forma profissionais capazes de analisar as relações entre países, organizações e empresas internacionais, buscando soluções para problemas globais.'
            ],
            [
                'nome' => 'Serviço Social',
                'descricao' => 'Curso que forma assistentes sociais para atuar no planejamento e execução de políticas públicas e de ações sociais para pessoas e grupos em situação de vulnerabilidade.'
            ],
            [
                'nome' => 'Veterinária',
                'descricao' => 'Curso que forma médicos veterinários capacitados a diagnosticar e tratar doenças em animais, além de promover a saúde e o bem-estar animal.'
            ],
        ];
        $this->verifyTable('cursos', $cursos);
    }


    /**
     * manda array para customFactory::verifyTable()
     * @return array
     */
    protected function insertBolsas()
    {
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
     * manda array para customFactory::verifyTable()
     * @return array
     */
    protected function inserirSituacaoAluno()
    {
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
        ];
        $this->verifyTable('situacao_aluno', $situacao);
    }


    /**
     * manda array para customFactory::verifyTable()
     * @return array
     */
    protected function insertNivelEscolar()
    {
        $nivel_escolar = [
            ['nome' => 'Ensino Infantil'],
            ['nome' => 'Ensino Fundamental'],
            ['nome' => 'Ensino Médio'],
            ['nome' => 'Cursos Técnicos'],
            ['nome' => 'Cursos Preparatórios'],
        ];
        $this->insertDatas('nivel_escolar', $nivel_escolar);
    }


    /**
     * manda array para customFactory::verifyTable()
     * @return array
     */
    protected function insertAno()
    {
        $data = [];
        foreach([[1, 5], [2,9], [3, 3],[4,3], [5, 1]] as $nivel)
        {
            for($i=1; $i<=$nivel[1]; $i++)
            {
                $data[] = [
                    'nivel_escolar_id'=> DB::table('nivel_escolar')->find($nivel[0])->id,
                    'ano'=> $i
                ];
            }
        }
        $this->verifyTable('anos', $data);
    }


    /**
     * retorna idade
     * @string: date('Y-m-d')
     * @return int
     */
    protected function getIdade($data_nascimento)
    {
        return $age = Carbon::parse($data_nascimento)->age;
    }


    /**
     * manda array para customFactory::insertDatas()
     * @int $numero_de_pessoas
     * @return array
     */
    protected function makePessoa($numero_de_pessoa)
    {
        $pessoas = [];
        $alunos = [];
        $professores = [];
        $pais = [];
        while($numero_de_pessoa>0)
        {
            $prim_nome = $this->faker->firstName();
            $last_nome = $this->faker->lastName();
            $data_nascimento = $this->faker->dateTimeBetween('-'.$this->faker->biasedNumberBetween(2, 50, function($x) {
                return 11 - $x;
            }).' years', '-1 years')->format('Y-m-d');

            
            $idade = $this->getIdade($data_nascimento);

            $pessoas[] = [
                'nome' => $prim_nome . ' ' . $last_nome,
                'primeiro_nome' => $prim_nome,
                'ultimo_nome' => $last_nome,
                'email' => $prim_nome.'.'.$this->faker->email(),
                'data_de_nascimento' => $data_nascimento,
                'genero' =>$this->faker->randomElement(['Masculino', 'Feminino']),
                'cpf' => $this->faker->cpf(),
                'rg' => $this->faker->rg(),
                'endereco' => $this->faker->address(),
                'telefone' => (rand(0, 1))? $this->faker->landline(): null,
                'celular' => (rand(0, 1))? $this->faker->cellphone(): null,
                'senha' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ];
            $numero_de_pessoa--;
            

            if( $idade<18 ){
                $alunos[] = count($pessoas);
            }else{
                if($this->faker->randomDigit()<1){
                    $professores[] = count($pessoas);
                }else{
                    $pais[] = count($pessoas);
                }
            }
            
        }

        $this->insertDatas('pessoas', $pessoas);

        $this->makeProfessor($professores);
        $this->makeAluno($alunos);
        $this->makePais($pais);
    }


    /**
     * @array $ids
     * @return array
     */
    protected function makeProfessor($ids)
    {
        $datas = [];
        foreach($ids as $professor)
        {
            $curso = DB::table('cursos')->inRandomOrder()->first()->nome;
            $datas[] = [
                'id' =>$professor,
                'formacao_academica' => 'Formado em '. $curso,
                'experiencia_profissional' => 'Tem experiencia em '. $this->faker->randomElement(['lecionar ', 'estudar ', 'pesquisar ']). 'na área de '.$curso.' por '.$this->faker->numberBetween(3, 40).' anos',
            ];
        }
        $this->insertDatas('professores', $datas);
    }


    protected function makeAluno($ids)
    {
        $datas = [];
        $alunos = \App\Models\Pessoa::whereIn('id', $ids)->get();

        
        foreach($alunos as $aluno)
        {
            $idade = $this->getIdade($aluno->data_de_nascimento);
            
            $datas[] = [
                'id' => $aluno->id,
                'ano_id' => DB::table('anos')->find($idade)->id,
                'situacao_id' => DB::table('situacao_aluno')->inRandomOrder()->first()->id
            ];
        }
        $this->insertDatas('alunos', $datas);
        $this->attributeBolsa();
    }


    protected function attributeBolsa()
    {
        $alunos = \App\Models\Aluno::all();

        $datas = [];
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
        $this->insertDatas('alunos_bolsas', $datas);
    }    


    protected function makePais($pais)
    {
        $datas = [];
        foreach($pais as $pai)
        {
            $datas[] = [
                'pais_ou_responsavel_id' => $pai,
                'aluno_id' => DB::table('alunos')->inRandomOrder()->first()->id,
            ];
        }
        $this->insertDatas('pais_ou_responsaveis', $datas);
    
    }
}
