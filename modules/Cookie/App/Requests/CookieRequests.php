<?php

namespace Modules\Cookie\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CookieRequests extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'accepted_all' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'accepted_all.required' => 'Необходимо указать согласие на использование cookies',
            'accepted_all.boolean' => 'Некорректное значение согласия',
        ];
    }
}
