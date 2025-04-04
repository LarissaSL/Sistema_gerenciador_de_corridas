<?php

namespace App\Application\User;

use App\Models\users\UsersModel;

class SelectAdminUserByEmail
{
    public function execute($email) {
        return $this->select($email);
    }

    public function select($email) {
        return UsersModel::where('email', $email)
        ->whereHas('administrator')
        ->first();
    }
}
