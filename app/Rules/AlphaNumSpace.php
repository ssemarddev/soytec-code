<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Str;

class AlphaNumSpace implements InvokableRule
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
        if (!Str::of($value)->test('/[a-zA-Z0-9\sÁáÉéÍíÓóÚúÑñ]/ ')) {
            $fail('El :attribute debe contener caracteres alfanuméricos o espacios en blanco');
        }
    }
}
