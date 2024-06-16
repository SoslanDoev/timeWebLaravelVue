<?php

namespace App\Http\Requests\Question;

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
            'test_id' => 'required|integer',
            'text' => 'required|string|min:3|max:1000',
        ];
    }
        // Сообщения об ошибках (необязательно, для кастомизации сообщений)
        public function messages()
        {
            return [
                'test_id.required' => 'Поле test_id обязательно для заполнения.',
                'test_id.integer' => 'Поле test_id должно быть числом.',

                'text.required' => 'Поле text обязательно для заполнения.',
                'text.string' => 'Поле text должно быть строкой.',
                'text.min' => 'Поле text не может быть меньше 3 символов.',
                'text.max' => 'Поле text не может быть длиннее 1000 символов.',
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