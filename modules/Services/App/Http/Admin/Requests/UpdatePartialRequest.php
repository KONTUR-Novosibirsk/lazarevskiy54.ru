<?php

namespace Modules\Services\App\Http\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdatePartialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_active'         => 'sometimes|boolean',
            'is_featured'       => 'sometimes|boolean',
            'sort_order'        => 'sometimes|integer'
        ];
    }
}
