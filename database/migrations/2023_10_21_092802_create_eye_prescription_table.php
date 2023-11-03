<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEyePrescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eye_prescription', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('patient_id');
			$table->unsignedBigInteger('visit_id')->nullable();
			$table->unsignedBigInteger('doctor_id');
			$table->unsignedBigInteger('created_by')->nullable();
			$table->unsignedBigInteger('updated_by')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable();
            $table->longText('remarks')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')
				->references('id')->on('users')
				->onDelete('cascade')
				->onUpdate('cascade');
			$table->foreign('visit_id')
				->references('id')->on('patient_visits')
				->onDelete('cascade')
				->onUpdate('cascade');
			$table->foreign('doctor_id')
				->references('id')->on('users')
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
        Schema::dropIfExists('eye_prescription');
    }
}
