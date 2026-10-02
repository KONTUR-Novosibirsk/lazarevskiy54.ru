<?php

namespace Galtsevt\LaravelSeo\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTemplateSeoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'model_type' => 'string|required',
            'seo.title' => 'string|nullable|max:200',
            'seo.h1' => 'string|nullable|max:200',
            'seo.keywords' => 'string|nullable|max:250',
            'seo.description' => 'string|required|max:400',
        ];
    }
}
