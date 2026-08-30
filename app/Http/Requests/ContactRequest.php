<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required|min:5|max:50',
            'message' => 'required|min:5|max:500'
        ];
    }

    public function messages(){
        return[
            'name.required' => 'Поле Ім\'я є обов\'язковим',
            'email.required' => 'Поле email є обов\'язковим',
            'email.email' => 'Поле email зазначено не вірно',
            'subject.required' => 'Поле Тема є обов\'язковим',
            'subject.min' => 'Поле Тема повинно містити мінімум 5 символів',
            'subject.max' => 'Поле Тема повинно містити максимум 50 символів',
            'message.required' => 'Поле Повідомлення є обов\'язковим',
            'message.min' => 'Поле Повідомлення повинно містити мінімум 5 символів',
            'message.max' => 'Поле Повідомлення повинно містити максимум 50 символів'
        ];

    }

}
