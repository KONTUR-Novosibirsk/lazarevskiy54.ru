<?php

namespace Modules\InfoBlocks\App\Requests\Element;

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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'string|min:1|max:250',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpg,bmp,png',
        ];
    }
}
