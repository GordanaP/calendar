<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('doctors/{doctor}/scheduling-time-slots', 'Doctor\DoctorAjaxController@store')
    ->name('doctors.scheduling.time.slots');

/**
 * Doctor Appointment
 */
Route::get('doctors/{doctor}/appointments/list', 'Doctor\DoctorAppointmentAjaxController@index')
    ->name('doctors.appointments.list');
Route::resource('doctors.appointments', 'Doctor\DoctorAppointmentController')
    ->only('store');

/**
 * Appointment
 */
Route::resource('appointments', 'Appointment\AppointmentController');
