<?php

namespace App\Rules;

use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Validation\Rule;

class IsDoctorOfficeHour implements Rule
{
    /**
     * The doctor.
     *
     * @var \App\Doctor
     */
    public $doctor;

    /**
     * The appointment date.
     *
     * @var string
     */
    public $app_date;

    /**
     * Create a new rule instance.
     *
     * @param  \App\Doctor $doctor
     * @param  string $app_date
     */
    public function __construct($doctor, $app_date)
    {
        $this->doctor = $doctor;
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
        return App::make('doctor-schedule')
            ->setDoctor($this->doctor)
            ->isOfficeHour($value, $this->app_date);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The value must be during the doctor\'s office hours.';
    }
}
