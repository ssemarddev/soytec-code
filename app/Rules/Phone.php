<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Str;

class Phone implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if(!Str::of($value)->test('/[\+\s\d]/')) {
            $fail('El :attribute debe contener caracteres alfabéticos o espacios en blanco');
        }
    }
}
