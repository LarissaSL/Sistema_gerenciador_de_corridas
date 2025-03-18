<?php

namespace App\Application\Token;

use App\Models\token\LoginTokenModel;
use App\Models\users\AdministratorsModel;

class SelectLastTokenLogin
{
    public function execute($userId) {
        return $this->select($userId);
    }

    public function select($userId) {
        $admin = AdministratorsModel::where('user_id', $userId)->first();

        if (!$admin) {
            return null; 
        }

    return LoginTokenModel::where('administrator_id', $admin->id)
        ->orderByDesc('created_at')
        ->select(['id', 'administrator_id', 'token', 'expires_at', 'status', 'attempt'])
        ->first();
    }
}
