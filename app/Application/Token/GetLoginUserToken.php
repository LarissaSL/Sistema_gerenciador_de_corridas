<?php

namespace App\Application\Token;

use App\Models\User;

class GetLoginUserToken
{
    public function __construct(
        protected InsertTokenLogin $insertTokenLogin,
        protected SelectLastTokenLogin $selectLastTokenLogin
    ) {}

    public function execute(int $userId)
    {
        return $this->resendOrCreate($userId);
    }
    
    /**
     * Verifica se existe um token para o membro e devolve o token conforme existência ou status
     *
     * @param  int $userId
     * @return string|null
     */
    private function resendOrCreate(int $userId)
    {
        $existsToken = $this->selectLastTokenLogin->execute($userId);
        $user = User::find($userId);

        // Token existir e não esta expirado
        if ($existsToken && $existsToken->status === 0 && $existsToken->expires_at > now()) {
            return $existsToken->token;
        }

        if (($existsToken && $existsToken->status === 2) && ($user && $user->status === 2)) {
            return null;
        }
        
        $newToken = $this->insertTokenLogin->execute($userId);

        return $newToken;
    }
}
