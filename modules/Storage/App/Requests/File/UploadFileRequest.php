<?php

namespace Modules\Storage\App\Requests\File;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fileable_type' => 'required|string',
            'fileable_id' => 'nullable|integer',
            'group' => 'required|string',
            'file' => 'required|mimes:jpg,bmp,png,heic,docx,zip,rar,pdf,xls',
        ];
    }
}
