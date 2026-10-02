<?php

namespace Modules\Menu\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLinkMenuRequest extends FormRequest
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
            'url' => 'required|string|max:250',
            'category_id' => 'required|exists:menu_categories,id',
        ];
    }
}
