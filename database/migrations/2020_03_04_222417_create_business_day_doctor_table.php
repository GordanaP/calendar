<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessDayDoctorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_day_doctor', function (Blueprint $table) {
            $table->foreignId('doctor_id')->constrained()
                ->onDelete('cascade');
            $table->foreignId('business_day_id')->constrained()
                ->onDelete('cascade');
            $table->time('start_at')->nullable();
            $table->time('end_at')->nullable();

            $table->unique(['doctor_id', 'business_day_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_day_doctor');
    }
}
