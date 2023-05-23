<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionAndRoleFactory extends customFactory
{
    
    public function definition()
    {
        dump('Starting Permission seeding');
        $rolesPermission = new PermissionAndRoleFactory();

        $rolesPermission->insertRoles();

        $rolesPermission->attributeRolesToAlunos();
        $rolesPermission->attributeRolesToProfessor();
        $rolesPermission->attributeRolesToPais();

        $rolesPermission->insertPermissions();
        $rolesPermission->attributePermissionToRole();
    }


    protected function insertRoles()
    {
        echo "    start insertRoles()". PHP_EOL;
        $datas = [];
        $roles_data = [
            'Administrador',
            'Diretor',
            'Vice-Diretor',
            'Professor',
            'Orientador Educacional',
            'Coordenador Pedagógico',
            'Bibliotecário',
            'Aluno',
            'Pais/Responsável',
        ];

        foreach( $roles_data as $role )
        {
            $datas[] = [
                'name'=> $role,
                'guard_name'=> \Spatie\Permission\Guard::getDefaultName(static::class),
                'created_at'=>now(),
                'updated_at'=> now()
            ];
        }
        $this->verifyTable('roles', $datas);
    }


    protected function attributeRolesToAlunos()
    {
        echo "    start attributeRolesToAlunos()". PHP_EOL;

        $model_has_roles =[];
        foreach(\App\Models\Aluno::all()->toArray() as $aluno)
        {
            $model_has_roles[] = [
                'role_id'=> 8,
                'model_type'=> 'App\Models\Pessoa',
                'model_id'=> $aluno['id']
            ];

            $this->insertDatasMidway('model_has_roles', $model_has_roles);
        }
        $this->insertDatas('model_has_roles', $model_has_roles);
    }


    protected function attributeRolesToProfessor()
    {
        echo "    start attributeRolesToProfessor()". PHP_EOL;

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
            }else if(count($model_has_roles)==3){
                $model_has_roles[] = [
                    'role_id'=> 7,
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
            $this->insertDatasMidway('model_has_roles', $model_has_roles);
        }
        $this->insertDatas('model_has_roles', $model_has_roles);
    }


    protected function attributeRolesToPais()
    {
        echo "    start attributeRolesToPais()". PHP_EOL;

        $model_has_roles = [];
        $pais = \App\Models\Pessoa::whereDoesntHave('Roles')->get();
        foreach($pais as $pai)
        {
            $model_has_roles[] = [
                'role_id'=> 8,
                'model_type'=> 'App\Models\Pessoa',
                'model_id'=> $pai->id
            ];

            $this->insertDatasMidway('model_has_roles', $model_has_roles);
        }
        $this->insertDatas('model_has_roles', $model_has_roles);
    }


    protected function insertPermissions()
    {
        echo "    start insertPermissions()". PHP_EOL;
        $datas = collect([
            'acervo',
            'aluno',
            'ano',
            'area_de_conhecimento',
            'atividade_extracurricular',
            'autor',
            'bolsa',
            'categoria_acervo',
            'classe',
            'curso',
            'disciplina',
            'editora',
            'estado',
            'estado_acervo',
            'idioma',
            'nacionalidade',
            'nivel_escolar',
            'pessoa',
            'professor',
            'situacao_acervo',
            'situacao_aluno',
            'tipo_acervo',
            'emprestimo',
            'multa',
            'notas',
            'permission',
            'role',
            'mensalidade',
            'presenca'
        ])->flatMap(function ($base) {
            return collect(['.create', '.read', '.update', '.delete', '.*'])->map(function ($action) use ($base) {
                return [
                    'name'=> $base.$action,
                    'guard_name'=> \Spatie\Permission\Guard::getDefaultName(static::class),
                    'created_at'=>now(),
                    'updated_at'=> now()
                ];
            });
        });
        $this->verifyTable('permissions', $datas);
    }


    protected function attributePermissionToRoleDatas($rolePermission)
    {
        foreach($rolePermission as $role)
        {
            foreach($role['permissions'] as $permission)
            {
                $datas[] = [
                    'permission_id'=> Permission::where('name', $permission)->value('id'),
                    'role_id'=> Role::where('name', $role['name'])->value('id')
                ];
            }
        }
        return $datas;
    }


    protected function attributePermissionToRole()
    {
        echo "    start attributePermissionToRole()". PHP_EOL;

        $datas = [];

        $rolePermission = [
            [
                'name'=>'Administrador',
                'permissions'=> [
                    'acervo.*',
                    'aluno.*',
                    'ano.*',
                    'area_de_conhecimento.*',
                    'atividade_extracurricular.*',
                    'autor.*',
                    'bolsa.*',
                    'categoria_acervo.*',
                    'classe.*',
                    'curso.*',
                    'disciplina.*',
                    'editora.*',
                    'estado.*',
                    'estado_acervo.*',
                    'idioma.*',
                    'nacionalidade.*',
                    'nivel_escolar.*',
                    'pessoa.*',
                    'professor.*',
                    'situacao_acervo.*',
                    'situacao_aluno.*',
                    'tipo_acervo.*',
                    'emprestimo.*',
                    'multa.*',
                    'notas.*',
                    'permission.*',
                    'role.*',
                    'mensalidade.*',
                    'presenca.*'
                ]
            ],
            [
                'name'=>'Diretor',
                'permissions'=> [
                    'acervo.read',
                    'aluno.*',
                    'ano.*',
                    'area_de_conhecimento.*',
                    'atividade_extracurricular.*',
                    'bolsa.*',
                    'classe.*',
                    'curso.*',
                    'disciplina.*',
                    'nivel_escolar.*',
                    'pessoa.*',
                    'professor.*',
                    'situacao_aluno.*',
                    'emprestimo.read',
                    'multa.read',
                    'notas.read',
                    'role.update',
                    'mensalidade.read',
                    'presenca.read'
                ]
            ],
            [
                'name'=>'Vice-Diretor',
                'permissions'=> [
                    'acervo.read',
                    'aluno.*',
                    'ano.*',
                    'area_de_conhecimento.*',
                    'atividade_extracurricular.*',
                    'bolsa.*',
                    'classe.*',
                    'curso.*',
                    'disciplina.*',
                    'nivel_escolar.*',
                    'pessoa.*',
                    'professor.*',
                    'situacao_aluno.*',
                    'emprestimo.read',
                    'multa.read',
                    'notas.read',
                    'mensalidade.read',
                    'presenca.read'
                ]
            ],
            [
                'name'=>'Professor',
                'permissions'=> [
                    'acervo.read',
                    'aluno.read',
                    'aluno.update',
                    'ano.read',
                    'area_de_conhecimento.read',
                    'atividade_extracurricular.create',
                    'atividade_extracurricular.read',
                    'atividade_extracurricular.update',
                    'bolsa.read',
                    'classe.read',
                    'classe.update',
                    'curso.read',
                    'disciplina.read',
                    'nivel_escolar.read',
                    'pessoa.read',
                    'professor.read',
                    'situacao_aluno.read',
                    'notas.*',
                    'presenca.*'
                ]
            ],
            [
                'name'=>'Orientador Educacional',
                'permissions'=> [
                    'acervo.read',
                    'aluno.read',
                    'ano.read',
                    'area_de_conhecimento.read',
                    'atividade_extracurricular.read',
                    'bolsa.read',
                    'curso.read',
                    'disciplina.read',
                    'nivel_escolar.read',
                    'pessoa.read',
                    'situacao_aluno.read',
                    'emprestimo.read',
                    'multa.read',
                    'notas.read',
                    'presenca.read'
                ]
            ],
            [
                'name'=>'Coordenador Pedagógico',
                'permissions'=> [
                    'acervo.read',
                    'aluno.read',
                    'aluno.update',
                    'ano.read',
                    'area_de_conhecimento.*',
                    'atividade_extracurricular.read',
                    'bolsa.read',
                    'classe.read',
                    'classe.update',
                    'curso.read',
                    'disciplina.read',
                    'nivel_escolar.read',
                    'pessoa.read',
                    'professor.read',
                    'professor.update',
                    'situacao_aluno.read',
                    'situacao_aluno.update',
                    'notas.*',
                    'mensalidade.read',
                    'presenca.read',
                    'presenca.update'
                ]
            ],
            [
                'name'=>'Bibliotecário',
                'permissions'=> [
                    'acervo.*',
                    'autor.*',
                    'categoria_acervo.*',
                    'editora.*',
                    'estado_acervo.*',
                    'idioma.*',
                    'nacionalidade.*',
                    'situacao_acervo.*',
                    'tipo_acervo.*',
                    'emprestimo.*',
                    'multa.*',
                ]
            ],
            [
                'name'=>'Aluno',
                'permissions'=> [
                    'acervo.read',
                    'aluno.read',
                    'ano.read',
                    'atividade_extracurricular.read',
                    'bolsa.read',
                    'curso.read',
                    'disciplina.read',
                    'situacao_aluno.read',
                    'emprestimo.read',
                    'multa.read',
                    'notas.read',
                    'mensalidade.read',
                    'presenca.read'
                ]
            ],
            [
                'name'=>'Pais/Responsável',
                'permissions'=> [
                    'acervo.read',
                    'aluno.read',
                    'ano.read',
                    'atividade_extracurricular.read',
                    'bolsa.read',
                    'curso.read',
                    'disciplina.read',
                    'situacao_aluno.read',
                    'emprestimo.read',
                    'multa.read',
                    'notas.read',
                    'mensalidade.read',
                    'mensalidade.update',
                    'presenca.read'
                ]
            ],
        ];
        $this->verifyTable('role_has_permissions', $this->attributePermissionToRoleDatas($rolePermission));
    }
}
