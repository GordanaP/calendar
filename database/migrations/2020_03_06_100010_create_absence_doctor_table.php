<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsenceDoctorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absence_doctor', function (Blueprint $table) {
            $table->foreignId('doctor_id')->constrained()
                ->onDelete('cascade');
            $table->foreignId('absence_id')->constrained()
                ->onDelete('cascade');
            $table->date('start_at');
            $table->unsignedInteger('duration')->default(5);
            $table->unique(['doctor_id', 'absence_id', 'start_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absence_doctor');
    }
}
