<?php

namespace App\Http\Controllers\Login;

use App\Application\Login\TwoFactorAuth\TwoFactorAuthSendEmail;
use App\Application\Token\GetLoginUserToken;
use App\Application\Token\SelectLastTokenLogin;
use App\Application\Token\VerifyTokenLogin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TwoFactorAuthController extends Controller
{
    public function __construct(
        protected TwoFactorAuthSendEmail $twoFactorAuthSendEmail,
        protected GetLoginUserToken $getLoginUserToken,
        protected VerifyTokenLogin $verifyTokenLogin,
        protected SelectLastTokenLogin $selectLastTokenLogin,
    ) {}

    public function sendToken()
    {
        try {
            $admId = Auth::id();
            $email = Auth::user()->email;
            $token = $this->getLoginUserToken->execute($admId);

            if ($token) {
                $this->twoFactorAuthSendEmail->execute($email, $token);
                return redirect()->route('twoFactorAuth.form')->with([
                    'success' => true,
                    'message' => 'O código de verificação foi enviado para o email',
                    'email' => $email,
                    'dismissible' => false,
                ]);
            } else {
                return redirect()->route('login.home')->with([
                    'error' => true,
                    'message' => 'Usuário bloqueado, entre em contato com o suporte.',
                    'dismissible' => false,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Erro ao enviar o token de verificação: ' . $e->getMessage());

            return redirect()->route('login.home')->with([
                'error' => true,
                'message' => 'Ocorreu um erro ao tentar enviar o código. Tente novamente mais tarde.',
                'dismissible' => true, 
            ]);
        }
    }

    public function formToken()
    {
        if (Auth::check()) {
            $email = Auth::user()->email;

            $idAdmin = Auth::id();
            $token = $this->selectLastTokenLogin->execute($idAdmin);

            $sizeToken = $token ? strlen($token->token) : 4;

            return view('Login.twoFactorVerify', compact('email', 'sizeToken'));
        } else {
            return redirect()->route('login.home');
        }
    }

    public function verifyToken(Request $request)
    {
        $tokenInserted = $request->input('2fa_code');
        $userId = Auth::id();

        $result = $this->verifyTokenLogin->execute($userId, $tokenInserted);

        // Verificação com sucesso
        if ($result['status']) {
            return redirect()->route('dashboard');
        } else {
            // Redireciona de volta com erros
            return redirect()
                ->route('twoFactorAuth.form')
                ->with([
                    'error' => true,
                    'message' => $result['message'],
                    'dismissible' => true, 
                ]);
        }
    }

    public function verifyTokenJson(Request $request)
    {
        $tokenInserted = $request->input('2fa_code');
        $userId = Auth::id();

        $result = $this->verifyTokenLogin->execute($userId, $tokenInserted, $isJson = true);

        return response()->json([
            'status' => $result['status'],
            'message' => $result['status'] ? 'Autenticação bem-sucedida.' : $result['message'],
            'dismissible' => true, 
        ], $result['status'] ? 200 : 422);
    }
}
