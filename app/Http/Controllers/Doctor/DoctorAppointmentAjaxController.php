<?php

namespace App\Http\Controllers\Doctor;

use App\Doctor;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DoctorAppointmentAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Doctor $doctor
     */
    public function index(Doctor $doctor): AnonymousResourceCollection
    {
        return AppointmentResource::collection($doctor->appointments->load('doctor', 'patient'));
    }
}
