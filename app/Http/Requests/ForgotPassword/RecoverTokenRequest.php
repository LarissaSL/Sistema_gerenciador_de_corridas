<?php

namespace App\Http\Requests\ForgotPassword;

use App\Models\passwordResetToken\PasswordResetTokenModel;
use App\Models\users\AdministratorsModel;
use App\Models\users\UsersModel;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class RecoverTokenRequest extends FormRequest
{
    protected $userId;

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
            'token' => ['required', 'string', function ($attribute, $value, $fail) {
                $this->validateToken($attribute, $value, $fail);
            }],
        ];
    }

    /**
     * Valida o token e verifica se o usuário é administrador
     */
    protected function validateToken($attribute, $value, $fail)
    {
        // 1. Verifica se o token existe na tabela password_reset_tokens
        $tokenData = PasswordResetTokenModel::where('token', $value)
                    ->where('expires_at', '>', now())
                    ->first();

        if (!$tokenData) {
            $this->redirectWithError('login.home', 'O Link de recuperação é inválido ou expirou.');
        }

        // 2. Obtém o usuário associado id de user do token
        $user = UsersModel::where('id', $tokenData->user_id)->first();

        if (!$user) {
            $this->redirectWithError('login.home', 'Nenhum usuário associado a este token foi encontrado.');
        }

        // 3. Verifica se o usuário está na tabela administrators
        $isAdmin = AdministratorsModel::where('user_id', $user->id) ->exists();

        if (!$isAdmin) {
            $this->redirectWithError('login.home', 'Apenas administradores podem redefinir a senha por este método.');
        }

        // Armazena o user_id para uso posterior
        $this->userId = $user->id;
    }

    /**
     * Get the user ID from validated token
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'message' => 'Erro de validação',
            'errors' => $validator->errors(),
        ], 422);

        throw new ValidationException($validator, $response);
    }

    protected function redirectWithError($route, $message)
    {
        throw new HttpResponseException(
            redirect()->route($route)->with('error', $message)
        );
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'token' => $this->route('token') ?? $this->input('token'),
        ]);
    }
}