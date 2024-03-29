<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_visits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->string('status')->nullable();
            $table->longText('findings')->nullable();
            $table->longText('complaints')->nullable();
            $table->longText('recommendations')->nullable();
            $table->longText('medical_history')->nullable();
            $table->longText('admiting_diagnosis')->nullable();
            $table->longText('final_diagnosis')->nullable();
            $table->longText('remarks')->nullable();
            $table->timestamp('visit_date')->nullable();
            $table->timestamp('session_start')->nullable();
            $table->timestamp('session_end')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('patient_id')
				->references('id')->on('users')
				->onDelete('cascade')
				->onUpdate('cascade');
            $table->foreign('doctor_id')
				->references('id')->on('users')
				->onDelete('cascade')
				->onUpdate('cascade');
            $table->foreign('service_id')
				->references('id')->on('services')
				->onDelete('cascade')
				->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_visits');
    }
}
