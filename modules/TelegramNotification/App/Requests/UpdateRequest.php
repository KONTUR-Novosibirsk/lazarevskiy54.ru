<?php

namespace Modules\TelegramNotification\App\Requests;

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
            'name' => 'required|string|max:250',
            'is_active' => 'required|boolean',
            'chat_id' => 'required|integer|unique:telegram_accounts,chat_id, ' . $this->account->id,
        ];
    }
}
