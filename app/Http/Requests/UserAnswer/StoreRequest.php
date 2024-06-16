<?php

namespace App\Http\Requests\UserAnswer;

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
            'user_id' => 'required|integer|exists:users,id',
            'question_id' => 'required|integer|exists:questions,id',
            'answer_id' => 'required|integer|exists:answers,id',
        ];
    }
        // Сообщения об ошибках (необязательно, для кастомизации сообщений)
        public function messages()
        {
            return [
                'user_id.required' => 'Поле обязательно для заполнения.',
                'user_id.integer' => 'Поле должно быть числом.',
                
                'question_id.required' => 'Поле обязательно для заполнения.',
                'question_id.integer' => 'Поле должно быть числом.',

                'answer_id.required' => 'Поле обязательно для заполнения.',
                'answer_id.integer' => 'Поле должно быть числом.',
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