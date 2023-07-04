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
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Factories\AcervoFactory::definition($num_editoras = 1000, $num_autores = 2000, $num_acervos = 50000);
        // Factories\PessoaCursoFactory::definition($num_pessoas = 15000);
        // Factories\AtividadeExtracurricularFactory::definition();
        // Factories\DisciplinaFactory::definition();
        Factories\AreaDeConhecimentoFactory::definition();
        Factories\ClasseFactory::definition();
        Factories\NotaFactory::definition();
        Factories\PermissionAndRoleFactory::definition();
        Factories\EmprestimoFactory::definition();
        Factories\SugestaoFactory::definition();
    }
}
