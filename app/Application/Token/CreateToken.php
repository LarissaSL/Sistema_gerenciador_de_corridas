<?php

namespace App\Application\Token;
use Illuminate\Support\Str;

class CreateToken
{
    public function execute(int $size = 4)
    {
        return $this->createToken($size);
    }

    /**
     * Cria o Token usado para o 2FA no Login do Usuário
     *
     * @param  int $size
     * @return string
     */
    private function createToken(int $size = 4)
    {
        try {
            return str_pad(random_int(0, 9999), $size, '0', STR_PAD_LEFT);
        
        } catch (\Exception $e) {
            throw new \Exception('Erro ao criar o token: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
        }   
    }
}
