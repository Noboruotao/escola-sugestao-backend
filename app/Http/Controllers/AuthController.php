<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Models\Pessoa;
use Exception;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Cookie;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{
    public function __construct(Pessoa $pessoa, Emprestimo $emprestimo)
    {
        $this->pessoa = $pessoa;
        $this->emprestimo = $emprestimo;
    }


    public function login(Request $request)
    {
        try {
            $credencials = $request->only('email', 'senha');

            $pessoa = $this->pessoa->getPessoaByEmail($credencials['email']);

            if (!$pessoa || !Hash::check($credencials['senha'], $pessoa->senha)) {

                return response()->json(['success' => false, 'erro' => 'Usuário ou Senha inválidos!', 'message' => 'NOT FOUND'], 401);
            }
            $token = auth()->login($pessoa);

            return response()->json(['success' => true, 'token' => $token, 'message' => 'LOGGED'], 200);
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'erro' => $th, 'message' => 'FAILED'], 401);
        }
    }


    public function logout(Request $request)
    {
        $logout = auth()->logout();
        return response()->json(['success' => true, 'token' => $logout, 'message' => 'LOGGED'], 200);
    }


    private function checkNotification()
    {
    }


    public function check(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['success' => false, 'message' => 'token_expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['success' => false, 'message' => 'token_invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['success' => false, 'message' => 'token_absent'], 401);
        }

        $userDatas = $user->toArray();
        $permissions = [];
        $roles = [];

        foreach ($user->roles as $role) {
            $rolePermissionsCacheKey = "role_permissions:$role->name";

            $rolePermissions = Cache::remember($rolePermissionsCacheKey, 86400, function () use ($role) {
                return $role->permissions()->pluck('name')->toArray();
            });

            foreach ($rolePermissions as $permission) {
                $permissions[$permission] = true;
            }

            $roles[] = $role->name;
        }

        return response()->json([
            'success' => true,
            'data' => $userDatas,
            'roles' => $roles,
            'permissions' => array_keys($permissions),
            'emprestimos_atrasados' => $this->emprestimo->checkEmprestimosAtrasadosQnt()
        ], 200);
    }
}
