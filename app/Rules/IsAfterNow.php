<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsAfterNow implements Rule
{
    /**
     * The appointment date.
     *
     * @var string
     */
    public $app_date;

    /**
     * Create a new rule instance.
     *
     * @param  string $doctor
     */
    public function __construct($app_date)
    {
        $this->app_date = $app_date;
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
        $now_date = now()->format('Y-m-d');
        $now_time = now()->format('H:i');

        return $this->app_date == $now_date ? $value > $now_time : ' ';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The appointment must be scheduled from now on.';
    }
}
