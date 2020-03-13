<?php

namespace App\Rules;

use App\Utilities\AppCarbon;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Validation\Rule;

class IsDoctorOfficeDay implements Rule
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
        return (new AppCarbon)->isValidDate($value)
            ? App::make('doctor-schedule')
                ->setDoctor($this->doctor)
                ->isOfficeDay($value)
            : '';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The value must be the doctor\'s office day.';
    }
}
