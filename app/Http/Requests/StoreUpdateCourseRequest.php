<?php

namespace App\Http\Requests;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //$id = $this->segment(3);
        //$course = Course::find($id);
        //return $course->user_id == auth()->user()->id;

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
            'short_name' => 'nullable|max:255',
            'url' => 'nullable',
            'image' => 'nullable|image|mimes:png,jpg|max:5120||dimensions:max_width=600,max_height=450',
            'file' => 'nullable|file|mimes:pdf',
            'type' => 'nullable',
            'code' => "nullable|unique:courses,code",
            'total_hours' => 'nullable',
            'published' => 'sometimes|boolean',
            'free' => 'sometimes|boolean',
            'price' => 'nullable',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['code'] = [
                'required',
                Rule::unique('courses')->ignore($this->route('id')),
            ];
        }

        return $rules;
    }
}
