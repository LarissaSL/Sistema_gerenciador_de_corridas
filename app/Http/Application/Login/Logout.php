<?php

namespace App\Http\Application\Login;

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
