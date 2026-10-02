<?php

namespace Modules\Services\App\Http\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'active'            => 'sometimes|bool',
            'search'            => 'sometimes|string|max:250',
            'order_by'          => "sometimes|string",
            'order_direction'   => "sometimes|string",
        ];
    }
}
