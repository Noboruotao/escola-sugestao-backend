<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Nacionalidade;

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


    public static function createAutor()
    {
        $nacionalidades = Nacionalidade::all();
        $locales = config('seeder_datas.locale');

        for ($index = 0; $index < 50; $index++) {
            
        }
    }
}
