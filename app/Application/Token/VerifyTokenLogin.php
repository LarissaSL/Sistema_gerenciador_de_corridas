<?php

namespace App\Application\Token;

use App\Models\token\LoginTokenModel;
use App\Models\User;
use App\Models\users\AdministratorsModel;
use Illuminate\Support\Facades\Auth;

class VerifyTokenLogin
{
    protected $idAdministrator;

    public function __construct(
        protected SelectLastTokenLogin $selectLastTokenLogin, ) {
    }

    public function execute($userId, $token, $isJson = false)
    {
        return $this->verifyToken($userId, $token, $isJson);
    }

    /**
     * Verifica se o token do usuário é válido e se está no status correto.
     * Se for válido, ele é marcado como verificado (status = 1).
     *
     * @param int $userId
     * @param string $token
     * @return array
     */
    public function verifyToken($userId, $token, $isJson)
    {
        $storedToken = $this->selectLastTokenLogin->execute($userId);
        $user = User::find($userId);

        if (!$storedToken || !$user) {
            return $this->response(false, 'Usuário ou token inválido.');
        }

        // Se o token ou usuário já estiverem bloqueados
        if ($storedToken->status === 2 || $user->status === 2) {
            return $this->blockUser($user);
        }

        // Se o token expirou, verificar se o usuário digitou um token antigo
        if ($this->isExpiredToken($token)) {
            return $this->response(false, 'Este token já expirou. Clique abaixo para reenviarmos seu token.');
        }

        // Se o token atual expirou
        if ($storedToken->expires_at < now()) {
            $storedToken->status = 3;
            $storedToken->save();

            return $this->response(false, 'O seu token expirou. Gere um novo para continuar.');
        }

        // Se o token for válido (ignora maiúsculas/minúsculas)
        if (strcasecmp($storedToken->token, $token) === 0) {
            return $this->validToken($storedToken, $isJson);
        }

        return $this->invalidToken($storedToken, $user, $isJson);
    }

     /**
     * Verifica se o token que o usuário está digitando é um que já foi expirado.
     *
     * @param string $token
     * @return array
     */
    private function isExpiredToken($token)
    {
        $idAdministrator = AdministratorsModel::select('id')->where('id' , Auth::id())->first();
        return LoginTokenModel::where('administrator_id', $idAdministrator)
            ->where('token', $token)
            ->where('status', 3) // 3 = Expirado
            ->exists();
    }

    private function validToken($storedToken, $isJson)
    {
        if($isJson) {
            return $this->response(true, 'Token verificado com sucesso.');
        }

        if ($storedToken->status === 0) {
            $storedToken->status = 1;
            $storedToken->attempt += 1;
            $storedToken->save();

            return $this->response(true, 'Token verificado com sucesso.');
        }

        return $this->response(true, 'Token já foi verificado. Pode realizar Login.');
    }

    private function invalidToken($storedToken, $user, $isJson)
    {
        if($isJson) {
            return $this->response(false, 'Token inválido, tente novamente.');
        }

        $storedToken->attempt++;
        // Se ultrapassou o limite de tentativas, bloqueia o usuário
        if ($storedToken->attempt >= 3) {
            $storedToken->status = 2;
            $storedToken->save();
            return $this->blockUser($user);
        }

        $storedToken->save();

        return $this->response(false, 'Token inválido, tente novamente.');
    }

    private function blockUser($user)
    {
        $user->status = 2;
        $user->save();

        return $this->response(false, 'Usuário bloqueado, entre em contato com o suporte.');
    }

    private function response($status, $message)
    {
        return [
            'status' => $status,
            'message' => $message
        ];
    }
}
