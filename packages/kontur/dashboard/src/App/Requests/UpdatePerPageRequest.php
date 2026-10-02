<?php

namespace Kontur\Dashboard\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerPageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'per_page' => 'required|integer',
        ];
    }
}
