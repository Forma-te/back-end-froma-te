<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="StoreUpdateModuleRequest",
 *     required={"name", "course_id"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the module"
 *     ),
 *     @OA\Property(
 *         property="course_id",
 *         type="integer",
 *         description="The ID of the course"
 *     ),
 *     @OA\Property(
 *         property="published",
 *         type="boolean",
 *         description="The published status of the module"
 *     )
 * )
 */

class StoreUpdateModuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $course = Product::find($this->get('product_id'));

        return Gate::allows('owner-course', $course);

        //return true;
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
            'name' => 'required|min:2|max:150',
        ];
    }
}
