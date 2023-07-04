<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Aluno;
use App\Models\AtividadesExtracurriculares;


class AtividadeExtracurricularFactory extends customFactory
{
    protected array $seederDatas;
    protected $faker;


    public function __construct()
    {
        $this->seederDatas = config('seeder_datas.ativExtraSeederData');
        $this->faker = \Faker\Factory::create('pt_BR');
    }


    public function definition()
    {
        dump('Starting Atividade Extracurricular seeding');
        $ativExtra = new AtividadeExtracurricularFactory();

        $ativExtra->insertTipoAtivExtra();
        $ativExtra->insertAtivExtra();
        $ativExtra->attributeAtivExtraToAluno();
    }


    protected function insertTipoAtivExtra()
    {
        echo "    start insertTipoAtivExtra()" . PHP_EOL;
        $this->verifyTable('tipos_de_atividade_extracurricular', $this->seederDatas['tipoAtivExtra']);
    }


    protected function insertAtivExtra()
    {
        echo "    start insertAtivExtra()" . PHP_EOL;
        $this->verifyTable('atividade_extracurriculares',  $this->seederDatas['ativExtra']);
    }


    protected function attributeAtivExtraToAluno()
    {
        echo "    start attributeAtivExtraToAluno()" . PHP_EOL;

        $todas_as_atividades = AtividadesExtracurriculares::pluck('id');

        Aluno::orderBy('id')->chunk(200, function (Collection $alunos) use ($todas_as_atividades) {
            foreach ($alunos as $aluno) {
                if ($this->faker->randomDigit() < 3) {
                    $atividade_extracurriculares = $todas_as_atividades->shuffle()->take(rand(1, 2));
                    foreach ($atividade_extracurriculares as $ativ_extra) {
                        $datas[] = [
                            'aluno_id' => $aluno->id,
                            'atividades_extracurriculares_id' => $ativ_extra,
                            'ativo' => ($atividade_extracurriculares->last() === $ativ_extra) ? 1 : null
                        ];
                    }
                }
            }
            $this->insertDatas('aluno_atividades_extracurriculares', $datas);
        });
    }
}
