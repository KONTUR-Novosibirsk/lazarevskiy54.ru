<?php

namespace Modules\News\App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DraftUpdateRequest extends FormRequest
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
            'title' => 'nullable|string|max:250',
            'alias' => 'nullable|string|max:250',
            'text' => 'nullable|string',
            'publication_date' => 'nullable|string',
            'sort' => 'nullable|integer'
        ];
    }
}
