<?php

namespace App\Http\Controllers\Password;

use App\Application\ForgotPassword\ForgotPasswordSendEmail;
use App\Application\ForgotPassword\ForgotPasswordService;
use App\Application\User\SelectAdminUserByEmail;
use App\Application\User\UpdatePassword;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPassword\RecoverPasswordRequest;
use App\Http\Requests\ForgotPassword\RecoverTokenRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForgetPasswordController extends Controller
{
    public function __construct(
        protected ForgotPasswordSendEmail $forgotPasswordSendEmail,
        protected SelectAdminUserByEmail $selectAdminUserByEmail,
        protected ForgotPasswordService $forgotPasswordService,
        protected UpdatePassword $updatePassword,
        
    ) {}

    public function index(){
        $email = session('email');

        if ($email) {
            session()->forget('email');
        }

        return view('ForgotPassword.forgotPassword', compact ('email'));
    }

    public function sendEmail(Request $request) {
        $user = $this->selectAdminUserByEmail->execute($request->email);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Não encontramos uma conta associada a este email. Verifique as informações ou cadastre-se.',
            ], 404);
        }

        $token = $this->forgotPasswordService->createToken($user->id);
        $link = route('forgetPassword.recover', ['token' => $token->token]);
        $emailSend = $this->forgotPasswordSendEmail->execute($request->email, $link, $user);

        if ($emailSend) {
            return response()->json([
                'success' => true,
                'message' => "Enviamos as instruções para criar uma nova senha para o $user->email. <br> Caso não veja o email na sua caixa de entrada, verique a pasta de spam e lixo eletrônico.",
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao enviar e-mail de recuperação de senha, tente novamente.',
            ], 500);
        }
    }

    public function recover(RecoverTokenRequest $request, $token) {
        return view('ForgotPassword.forgotPasswordRecover', compact ('token'));
    }

    public function updatePassword(RecoverPasswordRequest $request, $token) {
        $newPassword = $request->password;
        $user = $this->updatePassword->execute($token, $newPassword);

        if ($user) {
            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Senha alterada com sucesso!');
        }

        return redirect()->route('forgetPassword')->with('error', 'Não foi possível alterar a senha, link expirado ou problema no servidor, tente novamente mais tarde ou entre em contato com o suporte.');
    }
}
