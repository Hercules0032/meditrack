<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FutureDate implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Carbon::parse($value)->lte(now())) {
            $fail('The :attribute must be a future date.');
        }
    }
}
