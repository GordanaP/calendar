<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Absence extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'description'
    ];

    /**
     * The absence's doctors.
     */
    public function doctors(): BelongsToMany
    {
       return $this->belongsToMany(Doctor::class)
            ->as('day')
            ->withPivot('start_at', 'duration');
    }

}
