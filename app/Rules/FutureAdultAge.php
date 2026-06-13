<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FutureAdultAge implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $age = Carbon::parse($value)->age;

        if ($age < 1) {
            $fail('The :attribute must indicate the patient is at least 1 year old.');
        }
    }
}
