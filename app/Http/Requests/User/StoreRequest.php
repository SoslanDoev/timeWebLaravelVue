<?php

namespace App\Http\Requests\User;

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
            'name' => 'required|string|min:3|max:50',
            'surname' => 'required|string|min:3|max:50',
            "role" => "integer|min:0|max:5",
            "block" => "boolean",
            "group_id" => "required|integer|min:0",
            "email" => "required|email|min:3|max:255|unique:users",
            "password" => "required|string|min:3|max:255|confirmed", 
            // "password" => "required|string|required_with:password_confirmation|same:password_confirmation", 
            "password_confirmation" => "required|min:3|max:255|string"
        ];
    }
    
            // Сообщения об ошибках (необязательно, для кастомизации сообщений)
        public function messages()
        {
            return [
                'name.required' => 'Поле обязательно для заполнения.',
                'name.string' => 'Поле должно быть строкой.',
                'name.min' => 'Поле не может быть меньше 3 символов.',
                'name.max' => 'Поле не может быть длиннее 50 символов.',

                'surname.required' => 'Поле обязательно для заполнения.',
                'surname.string' => 'Поле должно быть строкой.',
                'surname.min' => 'Поле не может быть меньше 3 символов.',
                'surname.max' => 'Поле не может быть длиннее 50 символов.',

                'role.integer' => 'Поле должно быть целым числом.',
                'role.min' => 'Поле не может быть меньше 0.',
                'role.max' => 'Поле не может быть больше 5.',

                'block.required' => 'Поле обязательно для заполнения.',

                'group_id.required' => 'Поле обязательно для заполнения.',
                'group_id.integer' => 'Поле должно быть целым числом.',
                'group_id.min' => 'Поле не может быть меньше 0.',

                'email.required' => 'Поле обязательно для заполнения.',
                'email.email' => 'Поле должно быть действительным адресом электронной почты.',
                'email.min' => 'Поле не может быть меньше 3 символов.',
                'email.max' => 'Поле не может быть длиннее 255 символов.',
                'email.unique' => 'Поле уже существует в базе данных.',

                'password.required' => 'Поле обязательно для заполнения.',
                'password.string' => 'Поле должно быть строкой.',
                'password.confirmed' => 'Поле и подтверждение пароля не совпадают.',
                'password.min' => 'Поле не может быть меньше 4 символов.',
                'password.max' => 'Поле не может быть длиннее 255 символов.',

                'password_confirmation.required' => 'Поле обязательно для заполнения.',
                'password_confirmation.string' => 'Поле должно быть строкой.',
                'password_confirmation.min' => 'Поле не может быть меньше 4 символов.',
                'password_confirmation.max' => 'Поле не может быть длиннее 255 символов.',
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