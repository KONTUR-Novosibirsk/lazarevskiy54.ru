<?php

namespace Kontur\Dashboard\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GoogleRecaptcha implements ValidationRule
{

    public function __construct(protected string $action)
    {

    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (settings('recaptcha_status')) {
            $recaptcha = new \ReCaptcha\ReCaptcha(settings('recaptcha_secret_key'));
            $resp = $recaptcha->setExpectedAction($this->action)->setScoreThreshold(0.8)->verify($value);
            if (!$resp->isSuccess()) {
                $fail('Не пройдена проверка google recaptcha');
            }
        }
    }
}
