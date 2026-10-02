<?php

namespace Modules\Reviews\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'text' => 'required|string|max:2000',
            'job_title' => 'nullable|string|max:250',
            'sort' => 'nullable|integer'
        ];
    }
}
