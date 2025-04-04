<?php

namespace App\Http\Requests\ForgotPassword;

use Illuminate\Foundation\Http\FormRequest;

class RecoverPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'password' => [
                'required',
                'string',
                'min:8',              // mínimo 8 caracteres
                'regex:/[a-z]/',      // pelo menos uma letra minúscula
                'regex:/[A-Z]/',      // pelo menos uma letra maiúscula
                'regex:/[0-9]/',      // pelo menos um número
                'regex:/[@$!%*#?&]/', // pelo menos um caractere especial
                'confirmed',         // confirmação de senha
            ],
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'A senha é obrigatória',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres',
            'password.regex' => 'A senha deve conter letras maiúsculas, minúsculas, números e caracteres especiais',
            'password.confirmed' => 'As senhas não coincidem',
        ];
    }
}
