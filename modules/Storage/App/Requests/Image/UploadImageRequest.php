<?php

namespace Modules\Storage\App\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'imageable_type' => 'required|string',
            'imageable_id' => 'nullable|integer',
            'group' => 'required|string',
            'image' => 'required|mimes:' . config('laravel-storage.image_formats'),
            'prefix' => 'nullable'
        ];
    }
}
