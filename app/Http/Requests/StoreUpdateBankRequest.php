<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateBankRequest extends FormRequest
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
            'bank' => 'required',
            'account' => "required|unique:banks,account,{$id},Id",
            'iban' => "required|unique:banks,iban,{$id},Id",
            'phone_number' => [
                'required',
                'nullable',
                'string',
                'regex:/^\d{12}$/'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'bank.required' => 'O campo banco é obrigatório.',
            'account.required' => 'O campo Conta bancária é obrigatório.',
            'iban.required' => 'O campo IBAN é obrigatório.',
            'phone_number.required' => 'O número de telefone deve ter exatamente 12 dígitos no formato 244921271191.',
            'phone_number.regex' => 'O número de telefone deve ter exatamente 12 dígitos no formato 244921271191.',
        ];
    }
}
