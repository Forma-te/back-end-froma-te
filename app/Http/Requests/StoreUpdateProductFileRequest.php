<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProductFileRequest extends FormRequest
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
           'image' => 'sometimes|image|mimes:png,jpg,jpeg|max:1024|dimensions:width=600,height=450',
           'file' => 'sometimes|file|mimes:pdf|max:10240',
           'name' => 'required|min:5|max:255',
        ];
    }

    public function messages()
    {
        return [
            'product_id.exists' => 'O Curso selecionado é inválido.',
            'image.image' => 'O ficheiro deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser dos tipos: png, jpg, jpeg.',
            'image.max' => 'A imagem não pode exceder 1MB.',
            'image.dimensions' => 'A imagem deve ter as dimensões 600x450 pixels.',
            'file.mimes' => 'O ficheiro deve ser do tipo: pdf.',
            'file.max' => 'O tamanho máximo da imagem é de 10MB.',
            'name.required' => 'O nome é obrigatório.',
        ];
    }

}
