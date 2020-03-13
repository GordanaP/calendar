<?php

namespace App\Rules;

use App\Utilities\AppCarbon;
use Illuminate\Contracts\Validation\Rule;

class IsValidTime implements Rule
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
        return (new AppCarbon)->isValidTimeFormat($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid time.';
    }
}
