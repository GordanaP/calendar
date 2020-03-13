<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'start_at', 'patient_id'
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = ['start_at'];
    //
    protected $casts = [
        'start_at' => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['end_at'];

    /**
     * Get the appointment end time.
     *
     * @return string
     */
    public function getEndAtAttribute()
    {
        return $this->start_at->addMinutes(15)->toDateTimeString();
    }

    /**
     * The appointment's doctor.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * The appointment's patient.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }
}
