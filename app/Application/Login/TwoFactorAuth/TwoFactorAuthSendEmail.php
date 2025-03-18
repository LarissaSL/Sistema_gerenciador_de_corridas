<?php

namespace App\Application\Login\TwoFactorAuth;

use App\Mail\TwoFactorAuthEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TwoFactorAuthSendEmail
{
    public function execute($email, $token) {
        return $this->sendEmail($email, $token);
    }

    public function sendEmail($email, $token) {
        try {
            if (!Auth::check()) {
                Log::warning('Tentativa de envio de e-mail sem usuário autenticado.');
                return false;
            }

            if (Auth::user()->email !== $email) {
                Log::warning('Usuário autenticado tentou enviar um e-mail para outro endereço.', [
                    'user_email' => Auth::user()->email,
                    'attempted_email' => $email
                ]);
                return false;
            }

            $client = config('APP_NAME', 'Sistema Gerenciador de Corridas');
            $nameUser  = Auth::user()->name;
            $firstName = explode(' ', $nameUser)[0];

            Mail::to($email)->send(new TwoFactorAuthEmail([
                'fromName' => config('mail.from.name'),
                'fromEmail' => config('mail.from.address'),
                'subject' => 'Token de Login | SGC',
                'message' => '',
                'client' => $client,
                'nameUser' => $firstName,
                'token' => $token,
            ]));


            Log::info('E-mail de autenticação enviado com sucesso.');
            return true;

        } catch (\Exception $e) {
            Log::error('Erro ao enviar e-mail de autenticação de dois fatores.', [
                'error' => $e->getMessage(),
                'email' => $email
            ]);

            return false;
        }
    }
}
