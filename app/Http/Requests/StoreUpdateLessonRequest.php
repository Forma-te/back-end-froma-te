<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
   * @OA\Schema(
   *     schema="StoreUpdateLessonRequest",
   *     required={"module_id", "name"},
   *     @OA\Property(property="module_id", type="integer", description="The ID of the module"),
   *     @OA\Property(property="name", type="string", description="The name of the lesson", minLength=5, maxLength=100),
   *     @OA\Property(property="file", type="string", format="binary", description="The file associated with the lesson"),
   *     @OA\Property(property="url", type="string", description="The URL of the lesson", minLength=3, maxLength=100),
   *     @OA\Property(property="description", type="string", description="The description of the lesson"),
   *     @OA\Property(property="video", type="string", description="The video associated with the lesson")
   * )
   */


class StoreUpdateLessonRequest extends FormRequest
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
            'module_id' => 'required',
            'name' => 'required|min:5|max:100',
            'file' => 'nullable|file|mimes:pdf',
            'url' => "nullable|min:3|max:100|unique:lessons,url",
            'description' => 'nullable',
            'video' => 'nullable',
        ];
    }
}
