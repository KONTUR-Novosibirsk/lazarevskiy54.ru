<?php

namespace Modules\Shop\App\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
            'title' => 'required|string|max:250',
            'alias' => ['required', 'alpha_dash:ascii', Rule::unique('shop_categories', 'alias')
                ->where('parent_id', $this->parent_id ?: null)
                ->whereNot('id', $this->shopCategory->id)
            ],
            'description' => 'nullable|string',
            'show_on_index_page' => 'nullable|boolean',
            'parent_id' => 'nullable|integer',
            'filter_id' => 'nullable|exists:shop_filters,id',
            'sort' => 'nullable|integer'
        ];
    }
}
