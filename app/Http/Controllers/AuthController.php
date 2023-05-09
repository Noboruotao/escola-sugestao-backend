<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\LoginRequest;

use App\Models\Pessoa;

class AuthController extends Controller
{
    public function __construct(Pessoa $pessoa)
    {
        $this->pessoa = $pessoa;
    }


    public function home()
    {
        $pessoa = Pessoa::inRandomOrder()->first();
        return view('home', ['pessoa'=>$pessoa]);
    }


    public function login(LoginRequest $request)
    {
        try {
            $credencials = $request->only('usuario', 'senha');

            $pessoa = $this->pessoa->getPessoaByUsuario($credencials['usuario']);
            
            if (!is_null($pessoa) && password_verify( $credencials['senha'], $pessoa->senha) )
            {
                Auth::login($pessoa);
                $request->session()->regenerate();
                return redirect()->route('home')->with('success', 'Login Success');
            }

        } catch (Exception $e) {
            return $this->pessoa->backWithError('The provided email do not match our records');
        }
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home')->with('danger', 'Logout success');
    }
}
