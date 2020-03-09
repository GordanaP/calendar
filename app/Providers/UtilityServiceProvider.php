<?php

namespace App\Providers;

use App\Utilities\Holidays;
use App\Utilities\AppCarbon;
use App\Utilities\DoctorSchedule;
use App\Utilities\DoctorAbsences;
use App\Utilities\BusinessSchedule;
use Illuminate\Support\ServiceProvider;

class UtilityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance('carbon', new AppCarbon);
        $this->app->instance('business-schedule', new BusinessSchedule);
        $this->app->instance('doctor-schedule', new DoctorSchedule);
        $this->app->instance('doctor-absences', new DoctorAbsences);
        $this->app->instance('holidays', new Holidays);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
