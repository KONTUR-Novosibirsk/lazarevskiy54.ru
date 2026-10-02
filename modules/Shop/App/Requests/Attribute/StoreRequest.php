<?php

namespace Modules\Shop\App\Requests\Attribute;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => 'required|string|max:250|unique:shop_attributes,name',
            'type' => 'required|string|max:250',
            'dictionary.*.value' => ['string', Rule::requiredIf($this->type === 'select' || $this->type === 'multi_select')],
        ];
    }
}
