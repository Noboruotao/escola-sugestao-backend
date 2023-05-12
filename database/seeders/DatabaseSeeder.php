<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
// 
        // // \Database\Factories\AcervoFactory::definition($num_editoras = 10, $num_autores = 20, $num_acervos = 50);
// 
        // \Database\Factories\PessoaCursoFactory::definition($num_pessoas = 100);
// 
        // \Database\Factories\AtividadeExtracurricularFactory::definition();
// 
        // \Database\Factories\DisciplinaFactory::definition();
// 
        // \Database\Factories\AreaDeConhecimentoFactory::definition();
// 
        // \Database\Factories\ClasseFactory::definition();
// 
        // \Database\Factories\NotaFactory::definition();
// 
        // \Database\Factories\PermissionAndRoleFactory::definition();
// 
        // \Database\Factories\EmprestimoFactory::definition();

        \Database\Factories\SugestaoFactory::definition();
    }
}
