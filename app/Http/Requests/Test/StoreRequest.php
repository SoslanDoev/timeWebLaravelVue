<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:255',
            'description' => 'min:0|max:255',
            'duration' => 'required|integer|min:5|max:50',
            'discipline_id' => 'required|integer|exists:disciplines,id',
            'author_id' => 'required|integer|exists:authors,id',
        ];
    }
        // Сообщения об ошибках (необязательно, для кастомизации сообщений)
        public function messages()
        {   
            return [
                'title.required' => 'Поле обязательно для заполнения.',
                'title.string' => 'Поле должно быть строкой.',
                'title.min' => 'Поле не может быть меньше 3 символов.',
                'title.max' => 'Поле не может быть длиннее 255 символов.',

                'description.string' => 'Поле должно быть строкой.',
                'description.min' => 'Поле не может быть меньше 3 символов.',
                'description.max' => 'Поле не может быть длиннее 255 символов.',
                
                'duration.required' => 'Поле обязательно для заполнения.',
                'duration.integer' => 'Поле должно быть числом.',
                'duration.min' => 'Поле не может быть меньше 5 символов.',
                'duration.max' => 'Поле не может быть длиннее 50 символов.',

                'discipline_id.required' => 'Поле обязательно для заполнения.',
                'discipline_id.integer' => 'Поле должно быть числом.',
                
                'author_id.required' => 'Поле обязательно для заполнения.',
                'author_id.integer' => 'Поле должно быть числом.',
            ];
        }
    
        protected function failedValidation(Validator $validator)
        {
            throw new HttpResponseException(response()->json([
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors()
            ], 422));
        }
}