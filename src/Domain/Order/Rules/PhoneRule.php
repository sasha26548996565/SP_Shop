<?php

namespace Domain\Order\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_numeric($value) == false) {
            $fail('В номере телефона должен быть только цифры');
        }
    }
}
