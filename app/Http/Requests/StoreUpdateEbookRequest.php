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
            'image' => 'nullable|image|mimes:png,jpg|max:7000|dimensions:max_width=600,max_height=450',
            'file' => 'nullable|file|mimes:pdf',
            'product_type' => 'nullable',
            'code' => "nullable|unique:products,code,{$id},Id",
            'total_hours' => 'nullable',
            'published' => 'sometimes|boolean',
            'free' => 'sometimes|boolean',
            'price' => 'nullable',
            'discount' => 'nullable',
            'acceptsMcxPayment' => 'nullable',
            'acceptsRefPayment' => 'nullable',
            'product_type' => 'nullable',
            'allow_download' => 'nullable'
        ];

        return $rules;
    }
}
