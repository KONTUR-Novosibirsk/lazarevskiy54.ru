<?php

namespace Modules\Gallery\App\Requests\GalleryImage;

use Illuminate\Foundation\Http\FormRequest;

class SortImagesRequest extends FormRequest
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
            'images.*.id' => 'required|integer',
        ];
    }
}
