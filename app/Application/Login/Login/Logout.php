<?php

namespace App\Application\Login\Login;

use Illuminate\Support\Facades\Auth;

class Logout
{
    public function execute(){
        $this->logout();
    }

    private function logout(){
        Auth::logout();
    }
}
