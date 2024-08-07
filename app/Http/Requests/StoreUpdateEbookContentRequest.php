<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="StoreUpdateEbookContentRequest",
 *     required={"ebook_id" ,"name"},
 *  *     @OA\Property(
 *         property="ebook_id",
 *         type="integer",
 *         description="The ID of the ebook"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the EbookContent"
 *     ),
 *      @OA\Property(
 *         property="description",
 *         type="string",
 *         description="The description of the EbookContent"
 *     ),
 *     @OA\Property(
 *         property="file",
 *         type="string",
 *         description="The file of the EbookContent"
 *     ),
 *     @OA\Property(
 *         property="published",
 *         type="boolean",
 *         description="The published status of the EbookContent"
 *     )
 * )
 */

class StoreUpdateEbookContentRequest extends FormRequest
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
            'ebook_id' => 'required|exists:ebooks,id',
            'name' => 'required|min:5|max:255',
            'description' => 'nullable',
            'file' => 'sometimes|file|mimes:pdf',
        ];
    }
}
