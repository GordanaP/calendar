<?php

namespace App\Http\Requests;

use App\Rules\IsNotPast;
use App\Rules\IsAfterNow;
use App\Rules\IsValidDate;
use App\Rules\IsValidTime;
use Illuminate\Support\Arr;
use App\Rules\IsBusinessDay;
use App\Utilities\AppCarbon;
use App\Rules\IsDoctorOfficeDay;
use App\Rules\IsDoctorOfficeHour;
use Illuminate\Support\Facades\App;
use App\Rules\IsNotDoctorAbsenceDay;
use App\Rules\IsDoctorSchedulingSlot;
use App\Rules\IsDoctorFreeSchedulingSlot;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'app_date' => [
                'required',
                new isValidDate,
                'after_or_equal:today',
                new IsBusinessDay,
                new IsDoctorOfficeDay(\App\Doctor::first()),
                new IsNotDoctorAbsenceDay(\App\Doctor::first()),

            ],
            'app_time' => [
                'required', 'date_format:H:i',
            ]
        ];

        if ( App::make('doctor-schedule')->setDoctor(\App\Doctor::first())
                ->isValidOfficeDay($this->app_date))
        {
            return $this->addToRules($rules, 'app_time', $this->appTimeRules());
        }

        return $rules;
    }

    /**
     * Add new rules to the existing rules.
     *
     * @param array $rules
     * @param string $member
     * @param array $add
     */
    private function addToRules($rules, $member, $add): array
    {
        $pulled = Arr::pull($rules, $member);
        $rules[$member] = array_merge($pulled, $add);

        return $rules;
    }

    /**
     * The new rules related to the appointment time.
     */
    private function appTimeRules(): array
    {
        return [
            new IsDoctorOfficeHour(\App\Doctor::first(), $this->app_date),
            new IsAfterNow($this->app_date),
            new IsDoctorSchedulingSlot(\App\Doctor::first(), $this->app_date),
            new IsDoctorFreeSchedulingSlot(\App\Doctor::first(), $this->app_date),
        ];
    }
}
