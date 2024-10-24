<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProductDocFileRequest extends FormRequest
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
           'file' => 'sometimes|file|mimes:pdf,docx,xls,pptx,ps,ai,zip,rar|max:10240',
           'name' => 'sometimes|min:5|max:255',
        ];
    }

    public function messages()
    {
        return [
            'product_id.exists' => 'O Curso selecionado é inválido.',
            'file.image' => 'O ficheiro deve ser uma imagem.',
            'file.mimes' => 'O ficheiro deve ser dos tipos: docx, xls, pptx, ps, ai, zip, rar.',
            'file.max' => 'O ficheiro não pode exceder 10MB.',
            'file.dimensions' => 'A imagem deve ter no máximo 300x450 pixels.',
            //'name.required' => 'O nome é obrigatório.',
        ];
    }
}
