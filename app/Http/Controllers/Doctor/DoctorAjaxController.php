<?php

namespace App\Http\Controllers\Doctor;

use App\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;

class DoctorAjaxController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Doctor $doctor)
    {
        return response([
            'minTime' =>  App::make('doctor-schedule')
                ->setDoctor($doctor)->officeDayStartHour($request->app_date),
            'maxTime' => App::make('doctor-schedule')
                ->setDoctor($doctor)->officeDayEndHour($request->app_date),
            'bookedSlots' =>  App::make('doctor-schedule')->setDoctor($doctor)
                ->timepickerDisableTimeRanges($request->app_date)
        ]);
    }
}
