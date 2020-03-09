<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BusinessDay extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'day_iso', 'open', 'close'];

    /**
     * The doctors being in office on the specific business days.
     */
    public function doctors(): BelongsToMany
    {
       return $this->belongsToMany(Doctor::class)
            ->as('hour')
            ->withPivot('start_at', 'end_at');
    }

    /**
     * Find the business day by the iso index.
     *
     * @param  integer $iso
     */
    public static function findByIso($iso): BusinessDay
    {
        return static::where('iso', $iso)->firstOrFail();
    }

}
