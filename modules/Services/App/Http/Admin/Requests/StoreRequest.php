<?php

namespace Modules\Services\App\Http\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'              => 'required|string|max:250',
            'alias'             => 'required|string|max:250|unique:services,alias',
            'price'             => 'nullable|integer',
            'parent_id'         => 'nullable|integer',
            'content'           => 'nullable|string',
            'description'       => 'nullable|string',
            'is_active'         => 'nullable|boolean',
            'is_featured'       => 'nullable|boolean',
            'sort_order'        => 'nullable|integer'
        ];
    }
}
