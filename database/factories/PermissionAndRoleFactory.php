<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Professor;
use App\Models\Aluno;

class PermissionAndRoleFactory extends Factory
{
    public function definition()
    {
        dump('Starting Permission seeding');
        
    }


    public static function insertRoles()
    {
        $roles = array_map(function ($role) {
            return [
                'name' => $role,
                'guard_name' => \Spatie\Permission\Guard::getDefaultName(static::class),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, config('seeder_datas.roles'));

        Role::insert($roles);
    }


    public static function insertPermissions()
    {
        $guard_name = \Spatie\Permission\Guard::getDefaultName(static::class);
        foreach (config('seeder_datas.permissions') as $base) {
            foreach (['.create', '.read', '.update', '.delete', '.*'] as $action) {
                $permissions[] = [
                    'name' => $base . $action,
                    'guard_name' => $guard_name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        Permission::insert($permissions);
    }


    public static function attributePermissionToRole()
    {
        $permissions = Permission::all();
        $roles = Role::all();
        foreach (config('seeder_datas.rolePermission') as $role) {
            foreach ($role['permissions'] as $permission) {
                $datas[] = [
                    'permission_id' => $permissions->where('name', $permission)->first()->id,
                    'role_id' => $roles->where('name', $role['name'])->first()->id,
                ];
            }
        }
        DB::table('role_has_permissions')->insert($datas);
    }
}
