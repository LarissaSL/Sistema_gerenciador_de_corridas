<?php

namespace App\Application\ForgotPassword;

use App\Models\passwordResetToken\PasswordResetTokenModel;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordService
{
    /**
     * Cria um novo token de redefinição de senha
     *
     * @param int $userId
     * @return PasswordResetToken
     */
    public function createToken(int $userId): PasswordResetTokenModel
    {
        $existsToken = $this->findValidTokenUser($userId);
        if ($existsToken) {
            return $existsToken;
        }
        
        $this->deleteExistingTokens($userId);


        // Cria um novo token
        $token = Str::random(60);
        $expiresAt = Carbon::now()->addMinutes(10); 

        return PasswordResetTokenModel::create([
            'user_id' => $userId,
            'token' => $token,
            'expires_at' => $expiresAt
        ]);
    }

    /**
     * Busca um token válido
     *
     * @param string $token
     * @return PasswordResetTokenModel|null
     */
    public function findValidToken(string $token): ?PasswordResetTokenModel
    {
        return PasswordResetTokenModel::where('token', $token)
            ->where('expires_at', '>', Carbon::now())
            ->first();
    }

    /**
     * Busca um token válido para o usuário
     *
     * @param int $idUser
     * @return PasswordResetTokenModel|null
     */
    public function findValidTokenUser(int $idUser): ?PasswordResetTokenModel
    {
        return PasswordResetTokenModel::where('user_id', $idUser)
            ->where('expires_at', '>', Carbon::now())
            ->first();
    }

    /**
     * Remove tokens existentes para o usuário
     *
     * @param int $userId
     * @return void
     */
    public function deleteExistingTokens(int $userId): void
    {
        PasswordResetTokenModel::where('user_id', $userId)->delete();
    }

    /**
     * Busca um token específico
     *
     * @param string $token
     * @return PasswordResetTokenModel|null
     */
    public function getToken(string $token): ?PasswordResetTokenModel
    {
        return PasswordResetTokenModel::where('token', $token)->first();
    }

    /**
     * Gera e retorna apenas a string do token
     *
     * @return string
     */
    public function generateTokenString(): string
    {
        return Str::random(60);
    }
}