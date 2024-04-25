<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class Avatar implements InvokableRule
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
        if(file_exists(public_path("src/img/avatars/$value")) === false) {
            $fail('El avatar escogido no existe');
        }
    }
}
