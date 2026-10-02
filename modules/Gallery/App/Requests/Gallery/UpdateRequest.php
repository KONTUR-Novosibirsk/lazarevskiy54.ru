<?php

namespace Modules\Gallery\App\Requests\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|string|max:250',
            'alias' => 'required|string|max:250|unique:galleries,alias,' . $this->gallery->id,
            'text' => 'nullable|string|max:2000',
            'active' => 'required|boolean',
        ];
    }
}
