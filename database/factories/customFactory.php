<?php

namespace Database\Factories;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

use Illuminate\Support\Collection;

abstract class customFactory extends Factory
{
    /**
     * Verificar se ja existe valores na tabela(tabelas que 
     * são populadas uma unica vez)
     * entrada: $table_name é o nome da tabela
     * $datas é o array comas chaves
     */
    protected function verifyTable($table_name, $datas)
    {
        if (DB::table($table_name)->exists() == false) {
            $this->insertDatas($table_name, $datas);
        }
    }

    /**
     * Popular a tabela com insert(o valor que entra 
     * deve ter as chaves de acordo com o nome da coluna)
     * entrada: array
     */
    protected function insertDatas($table, &$datas)
    {
        $data = collect($datas)->map(function ($data) {
            return $data;
        });

        foreach (array_chunk($data->toArray(), 500) as $data_parts) {
            DB::table($table)->insert($data_parts);
        }

        if (is_array($datas)) {
            $datas = [];
        }

        if ($datas instanceof Collection) {
            $datas = collect();
        }
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
}
