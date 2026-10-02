<?php

namespace Modules\News\App\Requests;

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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:250',
            'alias' => 'required|string|max:250|unique:news,alias,' . $this->news->id,
            'text' => 'required|string',
            'publication_date' => 'required|string',
            'sort' => 'nullable|integer'
        ];
    }
}
