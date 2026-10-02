<?php

namespace Modules\Slider\App\Requests\Slide;

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
            'title' => 'required|string|max:250',
            'link' => 'nullable|url|max:250',
            'description' => 'nullable|string|max:2000',
            'sort' => 'nullable|integer'
        ];
    }
}
