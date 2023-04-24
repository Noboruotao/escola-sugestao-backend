<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;


class PessoaFactory extends customFactory
{
    
    public function definition()
    {
        
    }


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

            $pessoas[] = [
                'nome' => $prim_nome . ' ' . $last_nome,
                'primeiro_nome' => $prim_nome,
                'ultimo_nome' => $last_nome,
                'email' => $this->faker->safeEmail,
                'data_de_nascimento' =>$this->faker->dateTimeBetween('-20 years', '-5 years')->format('Y-m-d'),
                'genero' =>$this->faker->randomElement(['Masculino', 'Feminino']),
                'cpf' => $this->faker->cpf,
                'rg' => $this->faker->rg,
                'endereco' => $this->faker->address(),
                'telefone' => (rand(0, 1))? $this->faker->phone: null,
                'celular' => (rand(0, 1))? $this->faker->cellphone: null,
                'senha' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ];
            $numero_de_pessoa--;

            $dividir = $this->faker->randomDigit();
            if($dividir <= 2){
                $professores[] = count($pessoas);
            }else if($dividir <= 7){
                $alunos[] = count($pessoas);
            }else{
                $pais[] = count($pessoas);
            }
        }

        $this->insertDatas('pessoas', $pessoas);

        $this->makeProfessor($professores);
        $this->makeAluno($alunos);
        $this->makePais($pais);
    }


    protected function makeProfessor($professores)
    {
        $datas = [];
        foreach($professores as $professor)
        {
            $datas[] = [
                'id' =>$professor,
                'formacao_academica' => $this->faker->lexify('Formado em ?????, ????? e ?????'),
                'experiencia_profissional' => $this->faker->lexify('Tem experiência em ?????, ????? e ?????'),
            ];
        }
        $this->insertDatas('professores', '$datas');
    }


    protected function makeAluno($alunos)
    {
        $datas = [];
        foreach($alunos as $aluno)
        {
            $datas[] = [
                'ano' => $this->faker->randomDigitNot(0),
                'situacao_id' => DB::table('situacao_aluno')->inRandomOrder()->first()->id
            ];
        }
    }

    protected function makePais($pais)
    {
    
    }
}
