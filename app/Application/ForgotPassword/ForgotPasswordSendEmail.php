<?php

namespace App\Application\ForgotPassword;

use App\Mail\ForgotPasswordEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordSendEmail
{
    public function execute($email, $link, $user) {
        return $this->sendEmail($email, $link, $user);
    }

    public function sendEmail($email, $link, $user) {
        try {
            $client = config('APP_NAME', 'Sistema Gerenciador de Corridas');

            Mail::to($email)->send(new ForgotPasswordEmail([
                'fromName' => config('mail.from.name'),
                'fromEmail' => config('mail.from.address'),
                'subject' => 'Recuperar senha | SGC',
                'message' => '',
                'client' => $client,
                'nameUser' => $user->name . " " . $user->last_name,
                'link' => $link,
            ]));

            Log::info('E-mail de recuperação de senha enviado com sucesso.');
            return true;

        } catch (\Exception $e) {
            Log::error('Erro ao enviar e-mail de recuperação de senha.', [
                'error' => $e->getMessage(),
                'email' => $email
            ]);

            return false;
        }
    }
}
