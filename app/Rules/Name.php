<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Str;

class Name implements InvokableRule
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
        if(!Str::of($value)->test('/[a-zA-Z0-9\s ÁáÉéÍíÓóÚúÑñ()&%]/')) {
            $fail('El :attribute debe contener caracteres alfanuméricos o los caracteres especiales (,),& o %');
        }
    }
}
