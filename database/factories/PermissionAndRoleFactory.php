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
        $rolesPermission->attributeRolesToProfessor();
        $rolesPermission->attributeRolesToPais();
        
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


    protected function attributeRolesToAlunos()
    {
        $model_has_roles =[];
        foreach(\App\Models\Aluno::all()->toArray() as $aluno)
        {
            $model_has_roles[] = [
                'role_id'=> 8,
                'model_type'=> 'App\Models\Pessoa',
                'model_id'=> $aluno['id']
            ];
        }
        $this->insertDatas('model_has_roles', $model_has_roles);
    }


    protected function attributeRolesToProfessor()
    {
        $model_has_roles =[];
        foreach(\App\Models\Professor::all()->toArray() as $professor)
        {
            if(count($model_has_roles)==0){
                $model_has_roles[] = [
                    'role_id'=> 1,
                    'model_type'=> 'App\Models\Pessoa',
                    'model_id'=> $professor['id']
                ];    
            }else if(count($model_has_roles)==1){
                $model_has_roles[] = [
                    'role_id'=> 2,
                    'model_type'=> 'App\Models\Pessoa',
                    'model_id'=> $professor['id']
                ];    
            }else if(count($model_has_roles)==2){
                $model_has_roles[] = [
                    'role_id'=> 3,
                    'model_type'=> 'App\Models\Pessoa',
                    'model_id'=> $professor['id']
                ];    
            }else{
                $model_has_roles[] = [
                    'role_id'=> Role::whereIn('id', [4, 5, 6, 7])->inRandomOrder()->first()->id,
                    'model_type'=> 'App\Models\Pessoa',
                    'model_id'=> $professor['id']
                ];
            }
        }
        $this->insertDatas('model_has_roles', $model_has_roles);
    }


    protected function attributeRolesToPais()
    {
        $model_has_roles = [];
        $pais = \App\Models\Pessoa::whereDoesntHave('Roles')->get();
        foreach($pais as $pai)
        {
            $model_has_roles[] = [
                'role_id'=> 8,
                'model_type'=> 'App\Models\Pessoa',
                'model_id'=> $pai->id
            ];
        }

        $this->insertDatas('model_has_roles', $model_has_roles);
        
    }
}
