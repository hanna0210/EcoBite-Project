<?php

namespace App\Http\Livewire\Extensions\Emailer;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CommaSeparatedEmails implements Rule
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
        return !Validator::make(
            [
                "{$attribute}" => explode(';', $value)
            ],
            [
                "{$attribute}.*" => 'required|email'
            ]
        )->fails();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must have valid email addresses.';
    }
}