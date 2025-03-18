<?php

namespace App\Http\Controllers\Login;

use App\Application\Login\Login\Authenticator;
use App\Application\Login\Login\Logout;
use App\Http\Controllers\Controller;
use App\Http\Requests\Login\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function __construct(
        protected Authenticator $authenticator,
        protected Logout $logout,
    ) {}

    public function index(){
        return view('Login.login');
    }

    public function login(LoginRequest $request){

        // Encerra a sessão atual antes de tentar autenticar o novo usuário
        if (Auth::check()) {
            Auth::logout();
            Session::invalidate();
            Session::regenerateToken();
            Session::flush();
        }

        $credentials = $request->validated();

        $autenticado = $this->authenticator->execute($credentials);

        if ($autenticado) {
            // Lidar com usuários bloqueados
            if (Auth::user() && Auth::user()->status == 2) {
                Session::flash('error', 'Usuário bloqueado, entre em contato com o Suporte para lidar com a situação.');
                return $this->logout();
            }

            return redirect()->route('twoFactorAuth.send');
        }

        // Autenticação falhou
        Session::flash('email', $request->email);
        Session::flash('error', 'Não foi possivel autenticar o usuário. Verifique seu e-mail e senha por favor.');
        return redirect()->route('login.home');
    }

    public function logout() {
        $this->logout->execute();
        return redirect()->route('login.home');
    }
}
