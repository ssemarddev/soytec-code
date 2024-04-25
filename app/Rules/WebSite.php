<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Str;

class WebSite implements InvokableRule
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
        if (!Str::of($value)->test('/^https?:\/\/[\w\-]+(\.[\w\-]+)+[/#?]?.*$/ ')) {
            $fail('El :attribute debe ser una url válida, ejemplo: "http://www.example.com"');
        }
    }
}
