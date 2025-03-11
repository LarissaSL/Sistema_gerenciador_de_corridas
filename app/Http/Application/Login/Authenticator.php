<?php

namespace App\Http\Application\Login;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Authenticator
{
    public function execute($credentials)
    {
        return $this->autentic($credentials);
    }

    private function autentic($credentials)
    {
        try {
            $autenticado = Auth::attempt($credentials);
    
            return $autenticado;

        } catch (\Exception $e) {
            Log::error('Erro durante a autenticação: ' . $e->getMessage());
            throw new Exception('Erro durante a autenticação: ' . $e->getMessage());
    
            return false;
        }
    }
}
