<?php

namespace Kontur\Dashboard\App\Controllers;

class RecaptchaController extends \App\Http\Controllers\Controller
{
    public function info(): array
    {
        return [
            'recaptcha_status' => settings('recaptcha_status', default: false),
            'recaptcha_key' => settings('recaptcha_status') ? settings('recaptcha_key') : 'no_required'
        ];
    }
}
