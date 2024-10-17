<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreUpdateUserRequest",
 *     required={"email", "password"},
 *     @OA\Property(property="name", type="string", description="The name of the user", maxLength=255, nullable=true),
 *     @OA\Property(property="email", type="string", description="The email of the user", format="email", maxLength=255),
 *     @OA\Property(property="password", type="string", description="The password of the user", minLength=8),
 *     @OA\Property(property="password_confirmation", type="string", description="Password confirmation", minLength=8),
 *     @OA\Property(property="bibliography", type="string", description="A brief biography of the user", nullable=true),
 *     @OA\Property(property="phone_number", type="string", description="The phone number of the user in the format 244921271191", nullable=true, pattern="^\d{12}$"),
 *     @OA\Property(property="image", type="string", format="binary", description="Profile image of the user", nullable=true),
 *     @OA\Property(property="bi", type="string", description="User's identification number", nullable=true),
 *     @OA\Property(property="device_name", type="string", description="The name of the device being used", maxLength=255, nullable=true)
 * )
 */

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
            'name' => ['required', 'string', 'regex:/^[\pL\s]+$/u', 'min:2', function ($attribute, $value, $fail) {
                if (count(explode(' ', $value)) < 2) {
                    $fail('O campo ' . $attribute . ' deve conter o primeiro e último nome.');
                }
            }],
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
