<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories;
use Database\Factories\AreaFactory;

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
        Factories\AcervoFactory::definition();
    }
}
