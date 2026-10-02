<?php

namespace Galtsevt\LaravelSeo\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SeoRequest extends FormRequest
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
           'seo.title' => 'string|nullable|max:200',
           'seo.h1' => 'string|nullable|max:200',
           'seo.keywords' => 'string|nullable|max:250',
           'seo.description' => 'string|nullable|max:400',
           'seo.site_map' => 'boolean|nullable',
           'seo.changefreq' => 'required_with:site_map|string|nullable|max:40',
           'seo.priority' => 'required_with:site_map|numeric|nullable|max:40',
        ];
    }
}
