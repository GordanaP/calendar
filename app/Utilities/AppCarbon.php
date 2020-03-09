<?php

namespace App\Utilities;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AppCarbon extends Carbon
{
    /**
     * The carbon intervals in minutes.
     *
     * @param  string $start_at
     * @param  string $end_at
     * @param  integer $minutes
     */
    public function minutesIntervals($start_at, $end_at, $minutes): CarbonPeriod
    {
        return CarbonPeriod::since($start_at)->minutes($minutes)->until($end_at);
    }

    /**
     * Determine if the time is within the given time range.
     *
     * @param  string  $time
     * @param  string  $start
     * @param  string  $end
     */
    public function inTimeRange($time, $start, $end): bool
    {
        return $this->parse($time)->between($this->parse($start), $this->parse($end));
    }

    /**
     * The iso weekday for the given date.
     *
     * @param  string $date
     */
    public function isoIndex($date): int
    {
        return $this->parse($date)->dayOfWeek;
    }

    /**
     * Determine if the date is equal or after today.
     *
     * @param  string  $date
     */
    public function isEqualOrAfterToday($date): bool
    {
        $parsed = $this->parse($date);

        return $parsed->isToday() || $parsed->isFuture();
    }

    /**
     * Parse and format the date.
     *
     * @param  string $date
     * @param  string $format
     */
    public function parseAndFormat($date, $format='Y-m-d'): string
    {
        return $this->parse($date)->format($format);
    }

    /**
     * Create a date from the given string.
     *
     * @param  string $string
     * @param  string $format
     */
    public function fromFormat($string, $format = 'Y-m-d H:i'): string
    {
        return $this->createFromFormat($format, $string)->toDateTimeString();
    }

    /**
     * Create a date from the given date parameters.
     *
     * @param  string $year
     * @param  string $month
     * @param  string $date
     */
    public function fromDate($year, $month, $date): string
    {
        return $this->createFromDate($year, $month, $date);
    }

    /**
     * Create from time.
     *
     * @param  string $time
     */
    public function fromTime($time): string
    {
        return $this->createFromTimeString($time);
    }

    /**
     * Determine if the date has valid both the format and the value.
     *
     * @param  string $date
     */
    public function isValidDate($date): string
    {
       return $this->isValidDateFormat($date) && $this->isValidDateValue($date);
    }

    /**
     * Determine if the date has a valid value.
     *
     * @param  string  $date
     * @param  string  $format
     */
    public function isValidDateValue($date, $format='Y-m-d'): bool
    {
        return date($format, strtotime($date)) == $date;
    }

    /**
     * Determine if the date has a valid format.
     *
     * @param  string $date
     */
    public function isValidDateFormat($date): bool
    {
        $regex = '/^\d{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])$/';

        return preg_match($regex, $date);
    }

    /**
     * Determine if the time has a valid format.
     *
     * @param  string $time
     */
    public function isValidTimeFormat($time): bool
    {
        $regex = '/^(0[0-1]?[0-9]|2[0-3]):[0-5][0-9]$/';

        return preg_match($regex, $time);
    }
}