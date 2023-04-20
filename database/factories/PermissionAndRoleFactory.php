<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionAndRoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        ( Role::exists() == False )? seedRoles(): Null;
        
    }


    public function seedRoles()
    {
        $roles_data = [
            ['name' =>'Administrador'],
            ['name' =>'Diretor'],
            ['name' =>'Vice-Diretor'],
            ['name' =>'Professor'],
            ['name' =>'Orientador Educacional'],
            ['name' =>'Coordenador Pedagógico'],
            ['name' =>'Bibliotecário'],
            ['name' =>'Aluno'],
            ['name' =>'Pais/Responsável'],
        ];

        foreach( $roles_data as $role )
        {
            Role::create( $role );
        }
    }
}
