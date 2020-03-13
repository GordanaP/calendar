<?php

namespace App\Rules;

use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Validation\Rule;

class IsNotDoctorAbsenceDay implements Rule
{
    /**
     * The doctor.
     *
     * @var \App\Doctor
     */
    public $doctor;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($doctor)
    {
        $this->doctor = $doctor;
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
        return ! App::make('doctor-absences')
            ->setDoctor($this->doctor)
            ->isAbsenceDay($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The value must be the doctor\'s non-absence day.';
    }
}
