<?php

namespace Modules\Reviews\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFromPublicRequest extends FormRequest
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
            'name' => 'string|max:250|required',
            'text' => 'required|string|min:50|max:2000',
        ];
    }
}
