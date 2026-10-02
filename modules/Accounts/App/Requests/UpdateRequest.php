<?php

namespace Modules\Accounts\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Accounts\App\Rules\PhoneRule;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:accounts,email,' . $this->account->id,
            'phone' => ['required', 'string', new PhoneRule],
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

    protected function prepareForValidation()
    {
        $data = $this->all();

        if (empty($data['password'])) {
            unset($data['password']);
            unset($data['password_confirmation']);
            $this->replace($data);
        }
    }
}
