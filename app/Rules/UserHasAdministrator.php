<?php

namespace App\Rules;

use App\Models\users\UsersModel;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserHasAdministrator implements ValidationRule
{

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute  O nome do atributo 
     * @param  mixed  $value  O valor do atributo 
     * @param  \Closure  $fail 
     * 
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = UsersModel::where('email', $value)
                          ->whereHas('administrator') 
                          ->first();

        if (!$user) {
            $fail('Este sistema é apenas para usuários administratores.');
        }
    }
}
