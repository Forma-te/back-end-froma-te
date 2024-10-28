<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProductCourseImageRequest extends FormRequest
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
           'image' => 'sometimes|image|mimes:png,jpg,jpeg|max:1024|dimensions::width=600,height=450',
           'name' => 'sometimes|min:5|max:255',
        ];
    }

    public function messages()
    {
        return [
            'product_id.exists' => 'O Curso selecionado é inválido.',
            'image.image' => 'O ficheiro deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser dos tipos: png, jpg, jpeg.',
            'image.max' => 'A imagem não pode exceder 1MB.',
            'image.dimensions' => 'A imagem deve ter no máximo 600x450 pixels.',
            //'name.required' => 'O nome é obrigatório.',
        ];
    }
}
