<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginStoreRequest extends FormRequest
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
            "email" => "required|email|min:3|max:255",
            "password" => "required|string|min:3", 
        ];
    }
    
            // Сообщения об ошибках (необязательно, для кастомизации сообщений)
        public function messages()
        {
            return [
                'email.required' => 'Поле обязательно для заполнения.',
                'email.email' => 'Поле должно быть действительным адресом электронной почты.',
                'email.min' => 'Поле не может быть меньше 3 символов.',
                'email.max' => 'Поле не может быть длиннее 255 символов.',

                'password.required' => 'Поле обязательно для заполнения.',
                'password.string' => 'Поле должно быть строкой.',
                'password.confirmed' => 'Поле и подтверждение пароля не совпадают.',
                'password.min' => 'Поле не может быть меньше 4 символов.',
                'password.max' => 'Поле не может быть длиннее 255 символов.',
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