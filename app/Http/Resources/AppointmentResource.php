<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->patient->full_name,
            'description' => $this->patient->birthday,
            'start' => $this->start_at,
            'end' => $this->end_at,
            'backgroundColor' => $this->doctor->color,
            'borderColor' => $this->doctor->color,
            'constraint' => 'businessHours'
        ];
    }
}
