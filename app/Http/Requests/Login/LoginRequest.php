<?php

namespace App\Http\Requests\Login;

use App\Rules\UserHasAdministrator;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'max:255',
                'exists:users,email', 
                new UserHasAdministrator(), 
            ],
            'password' => 'required|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'O campo de e-mail é obrigatório.',
            'email.exists' => 'Este e-mail não está registrado em nosso sistema.',
            'email.max' => 'O e-mail não pode exceder 255 caracteres.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'password.required' => 'O campo de senha é obrigatório.',
            'password.max' => 'A senha não pode exceder 100 caracteres.',
        ];
    }
}
