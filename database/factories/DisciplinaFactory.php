<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DisciplinaFactory extends customFactory
{
    protected array $seederDatas;
    protected $faker;


    public function __construct()
    {
        $this->seederDatas = config('seeder_datas.disciplinaSeederData');
        $this->faker = \Faker\Factory::create('pt_BR');
    }


    public function definition()
    {
        dump('Starting Disciplina seeding');
        $disciplina = new DisciplinaFactory();

        $disciplina->insertTipoAvaliacao();
        $disciplina->insertSituacaoDisciplina();
        $disciplina->insertDisciplinas();
    }


    protected function insertTipoAvaliacao()
    {
        echo "    start insertTipoAvaliacao()" . PHP_EOL;
       $this->verifyTable('tipos_de_avaliacoes', $this->seederDatas['tipos_de_valiacao']);
    }


    protected function insertSituacaoDisciplina()
    {
        echo "    start insertSituacaoDisciplina()" . PHP_EOL;
        $this->verifyTable('situacao_da_disciplina', $this->seederDatas['situacao_da_disciplina']);
    }


    protected function insertDisciplinas()
    {
        echo "    start insertDisciplinas()" . PHP_EOL;
        $this->verifyTable('disciplinas', $this->seederDatas['disciplinas']);
    }
}
