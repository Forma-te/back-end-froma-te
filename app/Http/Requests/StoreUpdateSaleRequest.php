<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateSaleRequest extends FormRequest
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
            'course_id' => 'required',
            'user_id' => 'nullable',
            'name' => 'required',
            'instrutor_id' => 'nullable',
            'transaction' => 'nullable',
            'email_student' => 'required|email',
            'payment_mode' => 'nullable',
            'blocked' => 'nullable',
            'status' => 'nullable',
            'date_expired' => 'required'
        ];
    }
}
