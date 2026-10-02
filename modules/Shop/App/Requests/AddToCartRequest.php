<?php

namespace Modules\Shop\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
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
            'id' => 'required|integer|exists:shop_products,id',
            'count' => 'required|integer',
            'attributes' => 'nullable',
            'attributes.*.id' => 'required_with:attributes',
            'attributes.*.value' => 'required_with:attributes',
            'offer' => 'nullable',
            'offer.price' => 'required_with:offer',
        ];
    }
}
