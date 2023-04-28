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
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        \Database\Factories\AcervoFactory::definition();
        
        \Database\Factories\PessoaCursoFactory::definition();
        
        \Database\Factories\AtividadeExtracurricularFactory::definition();
        
        \Database\Factories\DisciplinaFactory::definition();
        
        \Database\Factories\AreaDeConhecimentoFactory::definition();
        
        \Database\Factories\ClasseFactory::definition();

        \Database\Factories\PermissionAndRoleFactory::definition();
    }
}
