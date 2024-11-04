<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateOrderBumpRequest extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'producer_id' => 'required|exists:users,id',
            'offer_product_id' => 'required|exists:products,id',
            'call_to_action' => 'required|min:5|max:255',
            'title' => 'required|min:5|max:255',
            'description' => 'required|min:5|max:255',
            'show_image' => 'sometimes|boolean',
        ];
    }

    /**
    * Custom validation messages.
    *
    * @return array<string, string>
    */
    public function messages(): array
    {
        return [
            'product_id.required' => 'O campo produto é obrigatório.',
            'product_id.exists' => 'O produto selecionado não existe.',
            'call_to_action.required' => 'O campo "chamada para ação" é obrigatório.',
            'call_to_action.min' => 'A "chamada para ação" deve ter no mínimo :min caracteres.',
            'call_to_action.max' => 'A "chamada para ação" não pode exceder :max caracteres.',
            'title.required' => 'O campo título é obrigatório.',
            'title.min' => 'O título deve ter no mínimo :min caracteres.',
            'title.max' => 'O título não pode exceder :max caracteres.',
            'description.required' => 'O campo descrição é obrigatório.',
            'description.min' => 'A descrição deve ter no mínimo :min caracteres.',
            'description.max' => 'A descrição não pode exceder :max caracteres.',
            'show_image.boolean' => 'O campo "mostrar imagem" deve ser verdadeiro ou falso.',
        ];
    }
}
