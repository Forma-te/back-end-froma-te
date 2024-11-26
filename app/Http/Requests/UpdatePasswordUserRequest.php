<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordUserRequest extends FormRequest
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
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|required_with:password|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'A palavra-passe é obrigatória.',
            'password.string' => 'A palavra-passe deve ser uma sequência de caracteres.',
            'password.min' => 'A palavra-passe deve ter pelo menos :min caracteres.',
            'password.confirmed' => 'A confirmação da palavra-passe não corresponde.',
            'password_confirmation.required' => 'A confirmação da palavra-passe é obrigatória.',
            'password_confirmation.required_with' => 'A confirmação da palavra-passe é obrigatória quando a palavra-passe é fornecida.',
            'password_confirmation.string' => 'A confirmação da palavra-passe deve ser uma sequência de caracteres.',
            'password_confirmation.min' => 'A confirmação da palavra-passe deve ter pelo menos :min caracteres.',
        ];
    }
}
