<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\Pessoa;
use Exception;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $accessToken = $request->header('Authorization');
        // dd($accessToken);

        if (empty($accessToken)) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        try {
            $decoded = self::decodeToken($accessToken);
            $user = Pessoa::find($decoded->id);
            Auth::guard('web')->login($user);
            dd(Auth::guard('web')->user());

            return $next($request);
        } catch (ExpiredException $e) {
            $refreshToken = $request->cookie('refresh_token');
            dd($refreshToken);
        } catch (Exception $e) {
            dd($e);
        }


        // if (!$request->expectsJson()) {
        //     return route('login');
        // }
    }


    private static function decodeToken($token)
    {
        return JWT::decode($token, new Key(env('JWT_SECRET'), env('JWT_ALGO')));
    }
}
