<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Periodo;
use App\Models\Disciplina;

class DisciplinaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
    }


    public static function createPeriodos()
    {
        $nivels = config('seeder_datas.nivel_escolar');
        for ($i = 1; $i <= 2; $i++) {
            $periodos[] = [
                'nivel_escolar_id' => 1,
                'periodo' => $i . 'º ano do ' . $nivels[0]['nome'],
            ];
        }

        for ($i = 1; $i <= 9; $i++) {
            $periodos[] = [
                'nivel_escolar_id' => 2,
                'periodo' => $i . 'º ano do ' . $nivels[1]['nome'],
            ];
        }

        for ($i = 1; $i <= 3; $i++) {
            $periodos[] = [
                'nivel_escolar_id' => 3,
                'periodo' => $i . 'º ano do ' . $nivels[2]['nome'],
            ];
        }

        Periodo::insert($periodos);
    }


    public static function attributeDisciplinaPeriodo()
    {
        $periodoId = 2;
        foreach (Disciplina::all() as $disciplina) {
            if ($disciplina->nome == "Matemática") {
                $periodoId++;
            }

            $disciplina->periodos()->attach($periodoId);
        }
    }
}
