<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateFileLessonRequest extends FormRequest
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
            'lesson_id' => 'required',
            'name' => 'required|min:5|max:255',
            'file' => 'required|file|mimes:pdf|max:10240',
        ];
    }

    public function messages()
    {
        return [
            'module_id.required' => 'O campo module_id é obrigatório.',
            'file.required' => 'O arquivo deve ser do tipo PDF.',
            'file.max' => 'O tamanho máximo da imagem é de 10MB.',
        ];
    }
}
