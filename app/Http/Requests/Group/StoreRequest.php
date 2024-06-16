<?php

namespace App\Http\Requests\Group;

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
            'name' => 'required|string|min:3|max:25|unique:groups',
        ];
    }
        // Сообщения об ошибках (необязательно, для кастомизации сообщений)
        public function messages()
        {
            return [
                'name.required' => 'Поле обязательно для заполнения.',
                'name.string' => 'Поле должно быть строкой.',
                'name.min' => 'Поле не может быть меньше 3 символов.',
                'name.max' => 'Поле не может быть длиннее 255 символов.',
                'name.unique' => 'Поле уже существует в базе данных.',
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