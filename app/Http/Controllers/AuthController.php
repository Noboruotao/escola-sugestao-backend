<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

use App\Models\Pessoa;

class AuthController extends Controller
{
    public function __construct(Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;
    }


    public function homeTest()
    {
        $pessoa = Pessoa::inRandomOrder()->first();
        return view('home', ['pessoa' => $pessoa]);
    }


    public function login(Request $request)
    {
        try {
            $credencials = $request->only('cpf', 'senha');

            $pessoa = $this->pessoa->getPessoaByCpf($credencials['cpf']);

            if (!is_null($pessoa) && password_verify($credencials['senha'], $pessoa->senha)) {

                $response = self::creatAccessToken($pessoa);

                return $response;
            }
        } catch (Exception $e) {
        }
    }


    public function check()
    {
        dump('check');
        // JWT::parseToken
        dd(Auth::user());
    }


    private static function createToken($user, $time = 15)
    {
        $private_key = env('JWT_SECRET');
        $alg = env('JWT_ALGO');
        $now_seconds = time();

        $payload = [
            "id" => $user->id,
            "nome" => $user->nome,
            "roles" => $user->roles->pluck('name'),
            "aut" => env('APP_URL'),
            "iat" => $now_seconds,
            "exp" => $now_seconds + (60 * $time),
        ];

        return JWT::encode($payload, $private_key, $alg);
    }


    private static function creatAccessToken($user)
    {
        $accessToken = self::createToken($user);
        $refreshToken = self::createToken($user, 60 * 24 * 30);

        $response = new Response(['success' => true, 'data' => compact('accessToken')]);
        $response->cookie('refresh_token', $refreshToken, 60 * 24 * 30, null, null, false, true);

        return $response;
    }
}
