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

        \Database\Factories\PermissionAndRoleFactory::definition();

        \Database\Factories\AcervoFactory::definition();

        \Database\Factories\PessoaCursoFactory::definition();
    }
}
