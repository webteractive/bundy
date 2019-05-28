<?php

namespace App\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class Webteractive implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Str::endsWith($value, [
            'eetech.com',
            'eetechmedia.com',
            'webteractive.co'
        ]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The email domain is not recognize.';
    }
}
