<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductFileImageRequest extends FormRequest
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
           'file' => 'sometimes|file|mimes:pdf,docx,xls,pptx,ps,ai,zip,rar|max:10240',
           'name' => 'required|min:5|max:255',
        ];
    }

    public function messages()
    {
        return [
            'product_id.exists' => 'O Curso selecionado é inválido.',
            'file.image' => 'O ficheiro deve ser uma imagem.',
            'file.mimes' => 'O ficheiro deve ser dos tipos: docx, xls, pptx, ps, ai, zip, rar.',
            'file.max' => 'O ficheiro não pode exceder 10MB.',
            'file.dimensions' => 'A imagem deve ter no máximo 600x450 pixels.',
        ];
    }
}
