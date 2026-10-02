<?php

namespace Modules\Shop\App\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            'alias' => ['required', 'alpha_dash:ascii', Rule::unique('shop_products', 'alias')
                ->when($this->category_id, fn($query) => $query->where('category_id', $this->category_id))
            ],
            'description' => 'nullable|string',
            'category_id' => 'required|exists:shop_categories,id',
            'price' => 'required|integer',
            'old_price' => 'nullable|integer',
            'active' => 'nullable|boolean',
            'hit' => 'nullable|boolean',
            'show_on_index_page' => 'nullable|boolean',
            'show_on_shop_index_page' => 'nullable|boolean',
            'attributes_for_edit.*.attribute_id' => 'integer|exists:shop_attributes,id',
            'attributes_for_edit.*.value' => 'required',
            'sort' => 'nullable|integer'
        ];
    }
}
