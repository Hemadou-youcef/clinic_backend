<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->date('date_appointment');
            $table->time('start_time_appointment');
            $table->time('end_time_appointment');
            $table->unique(['date_appointment' , 'start_time_appointment' ,'end_time_appointment'] , 'date_start_time_end_time_appointment');
            $table->string('state_appointment');
            $table->string('type_appointment');
            $table->unsignedBigInteger('patient_id');
            $table->timestamps();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
