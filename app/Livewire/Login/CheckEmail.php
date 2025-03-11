<?php

namespace App\Livewire\Login;

use App\Models\users\UsersModel;
use Livewire\Component;

class CheckEmail extends Component
{
    public $email = '';  
    public $message = '';
    public $isAdmin = true; 
    public $user = '';

    public function checkEmail()
    {
        // Verifica se o usuário existe e se ele é administrador
        $user = UsersModel::where('email', $this->email)
                          ->whereHas('administrator')
                          ->first();

        if (!$user) {
            $this->isAdmin = false;
            $this->message = "O E-mail não está cadastrado no sistema como Administrador.";
            return; 
        }

        $this->isAdmin = true;
        $this->message = "";
    }

    public function render()
    {
        return view('livewire.login.check-email');
    }
}
