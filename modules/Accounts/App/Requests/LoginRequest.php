<?php

namespace Modules\Accounts\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => 'required|string|min:3|max:255',
            'password' => 'required|string|min:6',
            'remember' => 'sometimes|boolean',
            'policy' => 'required|accepted',
        ];
    }
}
