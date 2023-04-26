<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionAndRoleFactory extends customFactory
{
    
    public function definition()
    {
        $rolesPermission = new PermissionAndRoleFactory();

        $rolesPermission->seedRoles();
        $rolesPermission->attributeRolesToAlunos();
        
    }


    protected function seedRoles()
    {
        if(Role::exists()==false){
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
    

    protected function getAlunos()
    {
        return \App\Models\Aluno::select('id')->get()->toArray();
    }


    protected function attributeRolesToAlunos()
    {
        $model_has_roles =[];
        foreach($this->getAlunos() as $aluno)
        {
            $model_has_roles[] = [
                'role_id'=> Role::find(8)->id,
                'model_type'=> 'App\Models\Pessoa',
                'model_id'=> $aluno['id']
            ];
        }
dump($model_has_roles);
        $this->insertDatas('model_has_roles', $model_has_roles);

    }


}
