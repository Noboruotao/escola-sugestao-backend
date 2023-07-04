<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Professor;
use App\Models\Aluno;

class PermissionAndRoleFactory extends customFactory
{
    protected array $seederDatas;
    protected $faker;


    public function __construct()
    {
        $this->seederDatas = config('seeder_datas.permissionSeederData');
        $this->faker = \Faker\Factory::create('pt_BR');
    }

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
        echo "    start insertRoles()" . PHP_EOL;

        foreach ($this->seederDatas['roles'] as $role) {
            $datas[] = [
                'name' => $role,
                'guard_name' => \Spatie\Permission\Guard::getDefaultName(static::class),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        $this->verifyTable('roles', $datas);
    }


    protected function attributeRolesToAlunos()
    {
        echo "    start attributeRolesToAlunos()" . PHP_EOL;


        Aluno::orderBy('id')->chunk(200, function (Collection $alunos) {
            foreach ($alunos as $aluno) {
                $model_has_roles[] = [
                    'role_id' => 8,
                    'model_type' => 'App\Models\Pessoa',
                    'model_id' => $aluno->id
                ];
            }
            $this->insertDatas('model_has_roles', $model_has_roles);
        });
    }


    protected function attributeRolesToProfessor()
    {
        echo "    start attributeRolesToProfessor()" . PHP_EOL;

        foreach (Professor::all()->toArray() as $professor) {
            if (Professor::count() == 0) {
                $model_has_roles[] = [
                    'role_id' => 1,
                    'model_type' => 'App\Models\Pessoa',
                    'model_id' => $professor['id']
                ];
            } else if (Professor::count() == 1) {
                $model_has_roles[] = [
                    'role_id' => 2,
                    'model_type' => 'App\Models\Pessoa',
                    'model_id' => $professor['id']
                ];
            } else if (Professor::count() == 2) {
                $model_has_roles[] = [
                    'role_id' => 3,
                    'model_type' => 'App\Models\Pessoa',
                    'model_id' => $professor['id']
                ];
            } else if (Professor::count() == 3) {
                $model_has_roles[] = [
                    'role_id' => 7,
                    'model_type' => 'App\Models\Pessoa',
                    'model_id' => $professor['id']
                ];
            } else {
                $model_has_roles[] = [
                    'role_id' => Role::whereIn('id', [4, 5, 6, 7])->inRandomOrder()->first()->id,
                    'model_type' => 'App\Models\Pessoa',
                    'model_id' => $professor['id']
                ];
            }
            if (count($model_has_roles) > 200) {
                $this->insertDatas('model_has_roles', $model_has_roles);
            }
        }
        $this->insertDatas('model_has_roles', $model_has_roles);
    }


    protected function attributeRolesToPais()
    {
        echo "    start attributeRolesToPais()" . PHP_EOL;

        $parents = DB::table('pais_ou_responsaveis')
            ->distinct('pais_ou_responsavel_id')
            ->orderBy('pais_ou_responsavel_id')
            ->get();

        $parents->chunk(500, function (Collection $pais) {
            foreach ($pais as $pai) {
                $model_has_roles[] = [
                    'role_id' => 8,
                    'model_type' => 'App\Models\Pessoa',
                    'model_id' => $pai->id
                ];
            }
            $this->insertDatas('model_has_roles', $model_has_roles);
        });
    }


    protected function insertPermissions()
    {
        echo "    start insertPermissions()" . PHP_EOL;

        $datas = collect($this->seederDatas['permissions'])->flatMap(function ($base) {
            return collect(['.create', '.read', '.update', '.delete', '.*'])->map(function ($action) use ($base) {
                $guard_name = \Spatie\Permission\Guard::getDefaultName(static::class);

                return [
                    'name' => $base . $action,
                    'guard_name' => $guard_name,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            });
        });
        $this->verifyTable('permissions', $datas);
    }


    protected function attributePermissionToRoleDatas($rolePermission)
    {
        $permissions = Permission::all();
        $roles = Role::all();
        foreach ($rolePermission as $role) {
            foreach ($role['permissions'] as $permission) {
                $datas[] = [
                    'permission_id' => $permissions->where('name', $permission)->first()->id,
                    'role_id' => $roles->where('name', $role['name'])->first()->id,
                ];
            }
        }
        return $datas;
    }


    protected function attributePermissionToRole()
    {
        echo "    start attributePermissionToRole()" . PHP_EOL;


        $rolePermission = [
            [
                'name' => 'Administrador',
                'permissions' => [
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
                'name' => 'Diretor',
                'permissions' => [
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
                'name' => 'Vice-Diretor',
                'permissions' => [
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
                'name' => 'Professor',
                'permissions' => [
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
                'name' => 'Orientador Educacional',
                'permissions' => [
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
                'name' => 'Coordenador Pedagógico',
                'permissions' => [
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
                'name' => 'Bibliotecário',
                'permissions' => [
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
                'name' => 'Aluno',
                'permissions' => [
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
                'name' => 'Pais/Responsável',
                'permissions' => [
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
        $this->verifyTable('role_has_permissions', $this->attributePermissionToRoleDatas($this->seederDatas['rolePermission']));
    }
}
