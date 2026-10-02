<?php

namespace Kontur\Dashboard\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWidgets extends FormRequest
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
            'widgets.*.id' => 'required|string',
            'widgets.*.active' => 'required|boolean',
            'widgets.*.size' => 'required|integer',
        ];
    }
}
