<?php

namespace App\Http\Requests\Answer;

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
            'question_id' => 'required|integer|exists:questions,id',
            'text' => 'required|string|min:3|max:1000',
            'points' => 'integer|min:0|max:7',
        ];
    }
        // Сообщения об ошибках (необязательно, для кастомизации сообщений)
        public function messages()
        {
            return [
                'question_id.required' => 'Поле обязательно для заполнения.',
                'question_id.integer' => 'Поле должно быть числом.',

                'text.required' => 'Поле обязательно для заполнения.',
                'text.string' => 'Поле должно быть строкой.',
                'text.min' => 'Поле не может быть меньше 3 символов.',
                'text.max' => 'Поле не может быть длиннее 1000 символов.',

                'points.integer' => 'Поле должно быть числом.',
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