<?php

namespace App\Application\Token;

use App\Models\token\LoginTokenModel;
use App\Models\users\AdministratorsModel;

class InsertTokenLogin
{
    public function __construct(protected CreateToken $createToken) {
    }

    public function execute($userId) {
        return $this->insertToken($userId);
    }

     /**
     * Cria e insere um token no banco
     *
     * @param  mixed $userId
     * @return string
     */
    private function insertToken($userId)
    {
        try {
            $token = $this->createToken->execute();
            
            $idAdministrator = AdministratorsModel::where('user_id', $userId)->first()->id;

            // Definindo a expiração do token para 10 minutos
            $expiresAt = now()->addMinutes(10);

            LoginTokenModel::create([
                'administrator_id' => $idAdministrator,
                'token' => $token,
                'attempt' => 0,
                'status' => 0,
                'expires_at' => $expiresAt, 
            ]);
            

            return $token;

        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage(), (int) $e->getCode(), $e);
        } 
    }
}
