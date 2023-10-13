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
            $table->bigIncrements('id');
            $table->integer('reference_number')->nullable();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('service_id');
            $table->enum('status', ['pending', 'confirmed', 'active', 'declined', 'canceled', 'done']);
            $table->longText('description')->nullable();
            $table->string('reason_of_cancel')->nullable();
            $table->string('reason_of_decline')->nullable();
            $table->timestamp('appointment_date')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
