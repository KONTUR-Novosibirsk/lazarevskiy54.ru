<?php

namespace Modules\Accounts\App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Validation\Validator;

class PhoneRule implements ValidationRule, ValidatorAwareRule
{
    protected ?Validator $validator;

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValidFormat($value)) {
            $fail('Некорректный формат телефона. Используйте +7 (XXX) XXX-XX-XX или 8 (XXX) XXX-XX-XX');
            return;
        }
        $normalized = $this->normalizePhone($value);
        $this->validator->setData(array_merge(
            $this->validator->getData(),
            [$attribute => $normalized]
        ));
    }

    protected function isValidFormat(string $phone): bool
    {
        return (bool)preg_match('/^(\+7|8)[\s(]*\d{3}[)\s]*\d{3}[\s-]*\d{2}[\s-]*\d{2}$/', $phone);
    }

    protected function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/[^\d]/', '', $phone);

        if (str_starts_with($digits, '8')) {
            $digits = '7'.substr($digits, 1);
        }

        return sprintf('+7 (%s) %s-%s-%s',
            substr($digits, 1, 3),
            substr($digits, 4, 3),
            substr($digits, 7, 2),
            substr($digits, 9, 2)
        );
    }

    public function setValidator(Validator $validator): static
    {
        $this->validator = $validator;
        return $this;
    }
}
