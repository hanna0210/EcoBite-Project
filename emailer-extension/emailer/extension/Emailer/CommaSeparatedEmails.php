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
        // Trim and filter empty values
        $emails = array_filter(array_map('trim', explode(';', $value)));
        
        if (empty($emails)) {
            return false;
        }
        
        return !Validator::make(
            [
                "{$attribute}" => $emails
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