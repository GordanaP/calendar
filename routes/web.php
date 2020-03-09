<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('doctors/{doctor}/appointments/list', 'Doctor\DoctorAppointmentAjaxController@index')
    ->name('doctors.appointments.list');
