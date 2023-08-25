<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Pessoa;
use Exception;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function __construct(Pessoa $pessoa)
    {
        $this->middleware('auth:api', ['except' => ['login']]);
        $this->pessoa = $pessoa;
    }


    public function login(Request $request)
    {
        error_log('login');
        try {
            $credencials = $request->only('email', 'senha');

            $pessoa = $this->pessoa->getPessoaByEmail($credencials['email']);

            if (!$pessoa || !Hash::check($credencials['senha'], $pessoa->senha)) {

                return response()->json(['success' => false, 'erro' => 'Usuário ou Senha inválidos!', 'message' => 'NOT FOUND'], 200);
            }
            $token = auth()->login($pessoa);

            return response()->json(['success' => true, 'token' => $token, 'message' => 'LOGGED'], 200);
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'erro' => $th, 'message' => 'FAILED'], 500);
        }
    }


    public function logout(Request $request)
    {
        error_log('logout');
        $logout = auth()->logout();
        return response()->json(['success' => true, 'token' => $logout, 'message' => 'LOGGED'], 200);
    }


    public function check(Request $request)
    {
        error_log('check');
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['success' => false, 'message' => 'user_not_found'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['success' => false, 'message' => 'token_expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['success' => false, 'message' => 'token_invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['success' => false, 'message' => 'token_absent'], 401);
        }
        return response()->json(['success' => true, 'data' => compact('user')], 200);
    }
}
