<?php

namespace App\Application\User;

use App\Application\ForgotPassword\ForgotPasswordService;
use App\Models\users\UsersModel;

class UpdatePassword
{
    public function __construct(
        protected ForgotPasswordService $forgotPasswordService,
    ) {}

    /**
     * Atualiza a senha do usuário, se o token realmente existir
     *
     * @param string $token
     * @param string $password
     * @return UsersModel|null
     */
    public function execute($token, $password) : UsersModel|null
    {
        $token = $this->forgotPasswordService->findValidToken($token);

        if($token) {
            $user = UsersModel::findOrFail($token->user_id);

            if($user && $user->isAdministrator()) {
                return $this->update($user, $password);
            }
        }

        return null;
    }
    
    /**
     * Atualiza a senha do usuário no banco de dados
     *
     * @param UsersModel $user
     * @param string $password
     * @return UsersModel|null
     */
    public function update($user, $password) : UsersModel|null
    {
        $status = $user->update([
            'password' => bcrypt($password),
        ]);

        if($status) {
            return $user;
        }

        return null;
    }

}

