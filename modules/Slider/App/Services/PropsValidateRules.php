<?php

namespace Modules\Slider\App\Services;

class PropsValidateRules
{
    public function input(): string
    {
        return 'nullable|string|max:255';
    }

    public function textarea(): string
    {
        return 'nullable|string|max:2000';
    }

    public function checkbox(): string
    {
        return 'nullable|boolean';
    }
}
