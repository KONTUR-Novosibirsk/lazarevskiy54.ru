<?php

namespace Modules\Slider\App\Requests\Slider;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250|unique:sliders,name,' . $this->slider->id,
            'code' => 'required|string|max:250|regex:/^[a-z]+$/|unique:sliders,code,' . $this->slider->id,
            'description' => 'nullable|string|max:2000',
            'props' => 'nullable|array',
            'props.*.key' => 'required|string',
            'props.*.name' => 'required|string',
            'props.*.type' => 'required|string',
        ];
    }
}
