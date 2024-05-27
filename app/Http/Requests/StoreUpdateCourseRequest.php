<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|min:5|max:255',
            'description' => 'nullable',
            'short_name' => 'required|max:255',
            'url' => 'nullable|url',
            'image' => 'nullable|image|mimes:png,jpg|max:5120||dimensions:max_width=600,max_height=450',
            'file' => 'nullable|file|mimes:pdf',
            'type' => 'nullable',
            'code' => "nullable|unique:courses,code",
            'total_hours' => 'nullable',
            'published' => 'sometimes|boolean',
            'free' => 'sometimes|boolean',
            'price' => 'nullable',
        ];

        if ($this->method() === 'PUT' || $this->method() === 'PATCH') {
            $rules['code'] = [
                'required',
                Rule::unique('Courses')->ignore($this->id),
            ];
        }

        return $rules;
    }
}
