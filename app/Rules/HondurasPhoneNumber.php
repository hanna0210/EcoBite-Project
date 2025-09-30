<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Propaganistas\LaravelPhone\PhoneNumber;

class HondurasPhoneNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $phone = new PhoneNumber($value, 'HN');
            
            // Check if it's a valid Honduras mobile number
            if (!$phone->isValid()) {
                return false;
            }
            
            // Format as national number and check if it's 8 digits
            $nationalNumber = $phone->formatNational();
            $digitsOnly = preg_replace('/[^0-9]/', '', $nationalNumber);
            
            // Honduras mobile numbers should be 8 digits (without country code)
            return strlen($digitsOnly) === 8;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid Honduras mobile number with 8 digits (e.g., +504 XXXX-XXXX).';
    }
}
