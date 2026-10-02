<?php

namespace Kontur\Dashboard\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateModules extends FormRequest
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
            'modules.*.id' => 'required|string',
            'modules.*.config.active' => 'nullable|boolean',
            'modules.*.config.withSidebar' => 'nullable|boolean',
            'modules.*.config.withHeader' => 'nullable|boolean',
            'modules.*.config.withWidget' => 'nullable|boolean',
        ];
    }
}
