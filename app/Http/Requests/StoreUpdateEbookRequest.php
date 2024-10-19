<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateEbookRequest extends FormRequest
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
        $id = $this->route('Id') ?? ''; // Obter o ID dos parâmetros da rota

        $rules = [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:5|max:255',
            'description' => 'nullable',
            'short_name' => 'nullable|max:255',
            'url' => 'nullable',
            'image' => 'nullable|image|mimes:png,jpg|max:7000|dimensions:max_width=300,max_height=450',
            'file' => 'nullable|file|mimes:pdf',
            'product_type' => 'nullable',
            'code' => "nullable|unique:products,code,{$id},Id",
            'total_hours' => 'nullable',
            'published' => 'sometimes|boolean',
            'free' => 'sometimes|boolean',
            'price' => 'sometimes',
            'discount' => 'nullable',
            'acceptsMcxPayment' => 'nullable',
            'acceptsRefPayment' => 'nullable',
            'product_type' => 'nullable',
            'allow_download' => 'nullable'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'category_id.required' => 'A categoria é obrigatória.',
            'category_id.exists' => 'A categoria selecionada não é válida.',
            'name.required' => 'O nome do produto é obrigatório.',
            'name.min' => 'O nome deve ter no mínimo 5 caracteres.',
            'name.max' => 'O nome não pode exceder 255 caracteres.',
            'short_name.max' => 'O nome curto não pode exceder 255 caracteres.',
            'image.image' => 'O ficheiro deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser do tipo: png ou jpg.',
            'image.max' => 'O tamanho máximo da imagem é de 7000KB.',
            'image.dimensions' => 'A imagem deve ter no máximo 300px de largura e 450px de altura.',
            'file.mimes' => 'O ficheiro deve ser do tipo: pdf.',
            'code.unique' => 'O código fornecido já está em uso.',
            'published.boolean' => 'O campo publicado deve ser verdadeiro ou falso.',
            'free.boolean' => 'O campo gratuito deve ser verdadeiro ou falso.',
            'price.required' => 'O preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um valor numérico.',
            'discount.numeric' => 'O desconto deve ser um valor numérico.',
            'acceptsMcxPayment.boolean' => 'O campo de aceitação de pagamento MCX deve ser verdadeiro ou falso.',
            'acceptsRefPayment.boolean' => 'O campo de aceitação de pagamento por referência deve ser verdadeiro ou falso.',
            'product_type.nullable' => 'O tipo de produto pode ser opcional.',
            'allow_download.boolean' => 'O campo de permitir download deve ser verdadeiro ou falso.',
        ];
    }

}
