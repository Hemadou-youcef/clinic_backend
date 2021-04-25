<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicinePrescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_prescription', function (Blueprint $table) {
            $table->unsignedBigInteger('prescription_id');
            $table->unsignedBigInteger('medicines_id');
            $table->primary(['prescription_id','medicines_id']);
            $table->string('dose');
            $table->timestamps();

            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade');
            $table->foreign('medicines_id')->references('id')->on('medicines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicine_prescription');
    }
}
