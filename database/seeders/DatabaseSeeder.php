<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Factories\PessoaFactory::definition();
        Factories\AlunoFactory::definition();
    }
}
