<?php

namespace App\Http\Requests\TestSchedule;

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
            'group_id' => 'required|integer',
            
            'start_time' => 'required|date|date_format:Y-m-d H:i:s',
            'end_time' => [
                'required',
                'date',
                'date_format:Y-m-d H:i:s',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) <= strtotime($this->start_time)) {
                        $fail("Поле должно быть датой после начала тестирования");
                    }
                }
            ],
        ];
    }
        // Сообщения об ошибках (необязательно, для кастомизации сообщений)
    public function messages()
    {
        return [
            'test_id.required' => 'Поле обязательно для заполнения.',
            'test_id.integer' => 'Поле должно быть числом.',
            
            'group_id.required' => 'Поле обязательно для заполнения.',
            'group_id.integer' => 'Поле должно быть числом.',
            
            'start_time.required' => 'Поле обязательно для заполнения.',
            'start_time.date' => 'Поле должно быть допустимой датой.',
            'start_time.date_format' => 'Поле должно соответствовать формату Y-m-d H:i:s.',

            'end_time.required' => 'Поле обязательно для заполнения.',
            'end_time.date' => 'Поле должно быть допустимой датой.',
            'end_time.date_format' => 'Поле должно соответствовать формату Y-m-d H:i:s.',
            'end_time.after' => 'Поле должно быть датой после начала тестирования.',
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