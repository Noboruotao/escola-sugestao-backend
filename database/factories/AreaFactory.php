<?php

namespace Database\Factories;

use App\Models\AreaConhecimento;
use App\Models\Disciplina;
use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
    }


    private static function attributeAreaDisciplina()
    {
        foreach (config('seeder_datas.areaDisciplina') as $disciplina_id => $disciplina_data) {
            $disciplina = Disciplina::find($disciplina_id);
            $areas = collect([]);
            foreach ($disciplina_data as $area_codigo) {
                $area = AreaConhecimento::where('codigo', $area_codigo)->first();
                $relatedAreas = $area->getRelatedAreas();
                $areas = $areas->merge($relatedAreas)->unique('codigo');
            }
            foreach ($areas as $area) {
                $disciplina->areas()->attach($area->codigo);
            }
        }
    }
}
