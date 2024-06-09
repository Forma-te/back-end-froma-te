<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUserRequest extends FormRequest
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
        $id = $this->route('Id') ?? '';

        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => "sometimes|required|string|email|max:255|unique:users,email,{$id},Id",
            'password' => 'sometimes|string|min:8|confirmed',
            'password_confirmation' => 'sometimes|required_with:password|string|min:8',
            'bibliography' => 'nullable|string',
            'phone_number' => [
                'sometimes',
                'nullable',
                'string',
                'regex:/^\d{12}$/'
            ],
            'image' => 'nullable|file',
            'bi' => 'nullable|string',
            'device_name' => 'nullable|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'password.required' => 'A senha é obrigatória.',
            'password_confirmation.required_with' => 'A confirmação da senha é obrigatória quando a senha é fornecida.',
            'phone_number.regex' => 'O número de telefone deve ter exatamente 12 dígitos no formato 244921271191.',
            'device_name.required' => 'O nome do dispositivo é obrigatório.',
        ];
    }
}
