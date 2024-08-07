<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateCategoryRequest extends FormRequest
{
    /**
     * @OA\Schema(
     *     schema="StoreUpdateCategoryRequest",
     *     type="object",
     *     title="Store Update Category Request",
     *     description="Request data for storing or updating a category",
     *     required={"name", "description", "elegant_font"},
     *     @OA\Property(
     *         property="name",
     *         type="string",
     *         description="Name of the category",
     *         example="Science"
     *     ),
     *     @OA\Property(
     *         property="description",
     *         type="string",
     *         description="Description of the category",
     *         example="Courses related to scientific subjects"
     *     ),
     *     @OA\Property(
     *         property="elegant_font",
     *         type="string",
     *         description="Elegant font associated with the category",
     *         example="Serif"
     *     )
     * )
     */

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
        $rules = [
            'name' => 'required|min:3|max:150',
            'description' => 'required|min:3|max:2000',
            'elegant_font' => 'required|min:3|max:100',
        ];
        return $rules;

    }
}
