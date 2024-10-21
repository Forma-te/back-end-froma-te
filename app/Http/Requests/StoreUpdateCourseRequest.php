<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="StoreUpdateCourseRequest",
 *     required={"category_id", "name"},
 *     @OA\Property(property="category_id", type="integer", description="The ID of the category"),
 *     @OA\Property(property="name", type="string", description="The name of the course", minLength=5, maxLength=255),
 *     @OA\Property(property="description", type="string", description="The description of the course", nullable=true),
 *     @OA\Property(property="short_name", type="string", description="The short name of the course", maxLength=255, nullable=true),
 *     @OA\Property(property="url", type="string", description="The URL of the course", nullable=true),
 *     @OA\Property(property="image", type="string", format="binary", description="The image of the course", nullable=true),
 *     @OA\Property(property="file", type="string", format="binary", description="The file associated with the course", nullable=true),
 *     @OA\Property(property="type", type="string", description="The type of the course", nullable=true),
 *     @OA\Property(property="code", type="string", description="The unique code of the course", nullable=true),
 *     @OA\Property(property="total_hours", type="string", description="The total hours of the course", nullable=true),
 *     @OA\Property(property="published", type="boolean", description="The published status of the course", nullable=true),
 *     @OA\Property(property="free", type="boolean", description="The free status of the course", nullable=true),
 *     @OA\Property(property="price", type="number", format="float", description="The price of the course", nullable=true)
 * )
 */

class StoreUpdateCourseRequest extends FormRequest
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
        $id = $this->route('id') ?? ''; // Obter o ID dos parâmetros da rota

        $rules = [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:5|max:255',
            'description' => 'nullable',
            'short_name' => 'nullable|max:255',
            'url' => 'nullable',
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:1024|dimensions:max_width=600,max_height=450',
            'file' => 'nullable|file|mimes:pdf',
            'product_type' => 'nullable',
            'code' => "nullable|unique:products,code,{$id},id",
            'total_hours' => 'nullable',
            'published' => 'sometimes|boolean',
            'free' => 'sometimes|boolean',
            'price' => 'sometimes',
            'discount' => 'nullable',
            'acceptsMcxPayment' => 'required',
            'acceptsRefPayment' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'category_id.required' => 'A categoria é obrigatória.',
            'category_id.exists' => 'A categoria selecionada é inválida.',
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter no mínimo 5 caracteres.',
            'name.max' => 'O nome não pode exceder 255 caracteres.',
            'short_name.max' => 'O nome curto não pode exceder 255 caracteres.',
            'image.image' => 'O ficheiro deve ser uma imagem.',
            'image.mimes' => 'A imagem deve ser dos tipos: png, jpg.',
            'image.max' => 'A imagem não pode exceder 7000KB.',
            'image.dimensions' => 'A imagem deve ter no máximo 600x450 pixels.',
            'file.mimes' => 'O ficheiro deve ser do tipo: pdf.',
            'code.unique' => 'O código já está em uso.',
            'published.boolean' => 'O valor de publicado deve ser verdadeiro ou falso.',
            'free.boolean' => 'O valor de gratuito deve ser verdadeiro ou falso.',
            'price.required' => 'O preço é obrigatório.',
            'acceptsMcxPayment.required' => 'O campo de pagamento MCX é obrigatório.',
            'acceptsRefPayment.required' => 'O campo de pagamento por referência é obrigatório.',
        ];
    }


}
