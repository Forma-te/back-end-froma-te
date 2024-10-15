<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerDetailsRequest extends FormRequest
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
            'name' => ['required', 'string', 'regex:/^[\pL\s]+$/u', 'min:2', function ($attribute, $value, $fail) {
                if (count(explode(' ', $value)) < 2) {
                    $fail('O campo ' . $attribute . ' deve conter o primeiro e último nome.');
                }
            }],
            'email' => 'required|email|max:255',
            'password' => 'sometimes|string|min:8',
            'phone_number' => 'required|string|min:13|max:13|regex:/^\+?[0-9]{9,13}$/'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'email.unique' => 'O email fornecido já está em uso.',
            'password.required' => 'O campo password é obrigatório.',
            'password.min' => 'A password deve ter pelo menos :min caracteres.',
            'phone_number.required' => 'O campo número de telefone é obrigatório.',
        ];
    }
}
