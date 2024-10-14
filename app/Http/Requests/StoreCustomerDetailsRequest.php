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
        $id = $this->route('Id') ?? '';

        return [
            'name' => ['required', 'string', 'regex:/^[\pL\s]+$/u', 'min:2', function ($attribute, $value, $fail) {
                if (count(explode(' ', $value)) < 2) {
                    $fail('O campo ' . $attribute . ' deve conter o primeiro e último nome.');
                }
            }],
            'email' => "required|string|email|max:255|unique:users,email,{$id},Id",
            'password' => 'sometimes|string|min:8',
            'phone_number' => 'required|string|min:10|max:15|regex:/^\+?[0-9]{9,15}$/'
        ];
    }
}
