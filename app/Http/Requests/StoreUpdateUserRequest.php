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
        $id = $this->route('id') ?? '';

        return [
            'name' => [
                'required',
                'string',
                'regex:/^[\pL\s]+$/u',
                'min:2',
                function ($attribute, $value, $fail) {
                    if (count(explode(' ', $value)) < 2) {
                        $fail('O campo ' . $attribute . ' deve conter o primeiro e último nome.');
                    }
                },
            ],
            'titular' => [
                'required',
                'string',
                'regex:/^[\pL\s]+$/u',
                'min:2',
                function ($attribute, $value, $fail) {
                    if (count(explode(' ', $value)) < 2) {
                        $fail('O campo ' . $attribute . ' deve conter o primeiro e último nome.');
                    }
                },
            ],
            'email' => "required|string|email|max:255|unique:users,email,{$id},id",
            'bank' => 'nullable|string',
            'password' => 'sometimes|string|min:8|confirmed',
            'password_confirmation' => 'sometimes|required_with:password|string|min:8',
            'bibliography' => 'nullable|string',
            'phone_number' => 'required|string|min:13|max:13|regex:/^\+?[0-9]{9,13}$/',
            'profile_photo_path' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            //'bi' => 'nullable|string|max:255',

            // Novos campos
            'account_number' => 'nullable|string|max:20|regex:/^\d+$/',
            'whatsapp' => 'required|string|min:13|max:13|regex:/^\+?[0-9]{9,13}$/',
            'iban' => 'nullable|string|regex:/^AO\d{2}\d{21}$/',
            'foreign_iban' => 'nullable|string|regex:/^[A-Z]{2}[0-9]{2}[A-Z0-9]{11,30}$/',
            'wise' => 'nullable|string|email|max:255',
            'paypal' => 'nullable|string|email|max:255',
            'proof_path' => 'nullable|file|mimes:pdf|max:10240',
            'user_facebook' => 'nullable|string|url|max:255',
            'user_instagram' => 'nullable|string|url|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'O campo nome deve conter apenas letras e espaços.',
            'name.min' => 'O nome deve ter pelo menos 2 caracteres.',
            'name.required' => 'O nome é obrigatório.',
            'name.*' => 'O campo nome deve conter o primeiro e último nome.',

            'email.required' => 'O email é obrigatório.',
            'email.unique' => 'O email já está registado.',
            'email.email' => 'O email deve ser um endereço válido.',

            'password.confirmed' => 'A confirmação da senha não corresponde.',
            'password.required' => 'A senha é obrigatória.',
            'password_confirmation.required_with' => 'A confirmação da senha é obrigatória quando a senha é fornecida.',

            'phone_number.regex' => 'O número de telefone deve ter exatamente 12 dígitos no formato correto, como +244921271191.',
            'phone_number.required' => 'O número de telefone é obrigatório.',

            'profile_photo_path.file' => 'O ficheiro de foto de perfil deve ser um ficheiro válido.',
            'profile_photo_path.mimes' => 'A foto de perfil deve estar no formato jpeg, png, jpg ou gif.',
            'profile_photo_path.max' => 'O tamanho da foto de perfil não pode exceder 2 MB.',

            'proof_path.required' => 'O comprovativo deve estar nos formatos pdf',
            'proof_path.max' => 'O comprovativo não pode exceder 10 MB.',

            'titular.max' => 'O nome do titular não pode exceder 255 caracteres.',

            'account_number.regex' => 'O número da conta deve conter apenas dígitos.',
            'account_number.max' => 'O número da conta não pode exceder 20 caracteres.',

            'iban.regex' => 'O IBAN deve conter apenas letras maiúsculas e números.',
            'iban.max' => 'O IBAN não pode exceder 34 caracteres.',

            'iban.regex' => 'O IBAN deve estar no formato correto para Angola: iniciar com AO, seguido por 23 dígitos.',

            'wise.regex' => 'O campo Wise deve ser um IBAN válido ou um endereço de e-mail.',
            'paypal.email' => 'O campo PayPal deve ser um endereço de e-mail válido.',

            'user_facebook.url' => 'O link do Facebook deve ser um URL válido.',
            'user_facebook.max' => 'O link do Facebook não pode exceder 255 caracteres.',

            'user_instagram.url' => 'O link do Instagram deve ser um URL válido.',
            'user_instagram.max' => 'O link do Instagram não pode exceder 255 caracteres.',

            'whatsapp.regex' => 'O número do WhatsApp deve ter exatamente 12 dígitos no formato correto, como +244921271191.',

            'foreign_iban.regex' => 'O IBAN Estrangeiro deve ser válido e seguir o formato internacional.',
        ];
    }

}
