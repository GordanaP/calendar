<?php

namespace App\Utilities;

use App\BusinessDay;
use App\Utilities\AppCarbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class DoctorSchedule extends AppCarbon
{
    /**
     * The doctor.
     *
     * @var \App\Doctor
     */
    public $doctor;

    /**
     * Set the doctor.
     *
     * @param \App\Doctor $doctor
     */
    public function setDoctor($doctor): DoctorSchedule
    {
        $this->doctor = $doctor;

        return $this;
    }

    /**
     * Determine if the time slot is within the doctor's scheduling time slots.
     *
     * @param  string  $slot
     * @param  string  $date
     */
    public function isSchedulingTimeSlot($slot, $date): bool
    {
        return $this->isOfficeDay($date)
            ? $this->schedulingTimeSlots($date)->contains($slot) : null;
    }

    /**
     * The doctor's scheduling time slots for the given day.
     *
     * @param  string $date
     */
    public function schedulingTimeSlots($date): ?Collection
    {
        $start_at = $this->officeDayStartHour($date);
        $end_at = $this->lastSchedulingTimeSlot($date);
        $minutes = $this->doctor->app_slot;

        $time_slots = $this->isOfficeDay($date)
            ? $this->minutesIntervals($start_at, $end_at, $minutes) : null;

        return $time_slots ? collect($time_slots)->map(function($time_slot) {
            return $time_slot->format('H:i');
        }) : null;
    }

    /**
     * Determine if the time is within the doctor's office hours on a given date.
     *
     * @param  string  $time
     * @param  string  $date
     */
    public function isOfficeHour($time, $date): bool
    {
        return $this->inTimeRange(
            $time,
            $this->officeDayStartHour($date),
            $this->lastSchedulingTimeSlot($date)
        );
    }

    /**
     * Tha doctor's last scheduled time slot on a given day.
     *
     * @param  \App\Doctor  $doctor
     * @param  string  $date
     * @param  integer $interval
     */
    public function lastSchedulingTimeSlot($date): string
    {
        $office_day_end_at = $this->officeDayEndHour($date);
        $app_slot = $this->doctor->app_slot;

        return $office_day_end_at
            ? $this->parse($office_day_end_at)
                ->subMinutes($app_slot)
                ->format('H:i') : '';
    }

    /**
     * The doctor's office day end hour.
     *
     * @param  string $date
     */
    public function officeDayEndHour($date): string
    {
        $office_day = $this->findOfficeDay($date);

        return $office_day ? $office_day->hour->end_at : '';
    }

    /**
     * The doctor's office day start hour.
     *
     * @param  string $date
     */
    public function officeDayStartHour($date): string
    {
        $office_day = $this->findOfficeDay($date);

        return $office_day ? $office_day->hour->start_at : '';
    }

    /**
     * Determine if the date is a valid office day.
     *
     * @param  string  $date
     */
    public function isValidOfficeDay($date): bool
    {
        return $this->isValideDate($date) &&
            App::make('business-schedule')->isBusinessDay($date) &&
            $this->isEqualOrAfterToday($date) &&
            $this->isOfficeDay($date);
    }

    /**
     * Determine if the doctor is in the office on the given day.
     *
     * @param  string  $date
     */
    public function isOfficeDay($date): bool
    {
        $date_iso = $this->parse($date)->dayOfWeek;

        return $this->doctor->business_days->map(function($day){
            return $day->iso;
        })->contains($date_iso);
    }


    /**
     * Find the doctor's specific office day.
     *
     * @param  string $date
     */
    public function findOfficeDay($date): ?BusinessDay
    {
        $date_iso = $this->isoIndex($date);

        return $this->doctor->business_days->where('id', $date_iso)->first();
    }

    /**
     * The doctor's office days.
     */
    public function officeDays(): Collection
    {
        return $this->doctor->business_days->map(function($day){
            return $day->iso;
        });
    }
}