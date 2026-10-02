<?php

namespace Modules\Shop\App\Requests\Offer;

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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'category_id' => 'required|exists:shop_categories,id',
            'products' => 'required',
            'products.*.id' => 'integer',
            'attributes' => 'required',
            'attributes.*.id' => 'integer',
            'sort' => 'nullable|integer'
        ];
    }
}
