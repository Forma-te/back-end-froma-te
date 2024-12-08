<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $id = $this->route('id') ?? ''; // Obter o ID dos parâmetros da rota

        $rules = [
            'module_id' => 'required',
            'name' => 'required|min:5|max:100',
            'published' => 'required|boolean',
            'url' => "nullable|min:3|max:100|unique:lessons,url,{$id},id",
            'description' => 'nullable',
            'is_presentation' => 'nullable|boolean',
            'video' => 'nullable',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'module_id.required' => 'O campo module_id é obrigatório.',
            'name.required' => 'O campo name é obrigatório.',
            'name.min' => 'O campo name deve ter pelo menos :min 5 caracteres.',
            'name.max' => 'O campo name não pode ter mais de :max 100 caracteres.',
            'file.mimes' => 'O arquivo deve ser do tipo PDF.',
            'url.unique' => 'O URL já está em uso por outra lição.'
        ];
    }
}
