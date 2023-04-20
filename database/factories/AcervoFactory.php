<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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


    public function seedTiposDeAcervo()
    {
        $tipos_acervo = [
            ['tipo'=>'Livro', 'multa'=>.6],
            ['tipo'=>'Periódicos', 'multa'=>.6],
            ['tipo'=>'Teses e Dissertações', 'multa'=>.8],
            ['tipo'=>'CD e DVD', 'multa'=>.8],
            ['tipo'=>'Mapas e Atlas', 'multa'=>.6],
            ['tipo'=>'Arquivos Digitais', 'multa'=>.7],
            ['tipo'=>'Acervo Infantil', 'multa'=>.4],
            ['tipo'=>'Acervo de Referência', 'multa'=>.6],
            ['tipo'=>'Coleções Especiais', 'multa'=>.6],
        ];

        
    }

    public function insertDatas($table, $entrada)
    {
        $data = collect($entrada)->map(function($data){
            return $data;
        });

        DB::table($table)->insert( $data->toArray() );
    }
}
