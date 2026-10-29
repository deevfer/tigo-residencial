<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class GuatemalaPhoneNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $phone = (string) $value;
        $hasValidGuatemalaPrefix = preg_match('/^[2-7]\d{7}$/', $phone) === 1;
        $hasRepeatedPattern = preg_match('/^(\d{1,4})\1+$/', $phone) === 1;

        if (! $hasValidGuatemalaPrefix || $hasRepeatedPattern || $this->isSequential($phone)) {
            $fail('Ingresa un numero telefonico valido de Guatemala.');
        }
    }

    private function isSequential(string $phone): bool
    {
        $ascending = true;
        $descending = true;

        for ($index = 1; $index < strlen($phone); $index++) {
            $previous = (int) $phone[$index - 1];
            $current = (int) $phone[$index];
            $ascending = $ascending && $current === ($previous + 1) % 10;
            $descending = $descending && $current === ($previous + 9) % 10;
        }

        return $ascending || $descending;
    }
}
