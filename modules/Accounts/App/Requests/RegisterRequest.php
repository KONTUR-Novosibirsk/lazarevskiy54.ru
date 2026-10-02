<?php

namespace Modules\Accounts\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Accounts\App\Rules\PhoneRule;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => 'nullable|string|min:3|max:255|unique:accounts',
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:accounts',
            'policy' => 'required|accepted',
            'phone' => ['nullable', 'string', new PhoneRule],
            'password' => 'nullable|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'phone' => 'Некорректный формат телефона. Используйте +7 (XXX) XXX-XX-XX или 8 (XXX) XXX-XX-XX',
            'password.confirmed' => 'Пароли не совпадают',
        ];
    }
}
