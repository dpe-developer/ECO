<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalHistoryReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_history_references', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('parent_id')->nullable();
			$table->unsignedBigInteger('child_id')->nullable();
			$table->string('type');
			$table->string('name');
			$table->string('description')->nullable();
			$table->unsignedBigInteger('created_by')->nullable();
			$table->unsignedBigInteger('updated_by')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable();
			$table->timestamps();

			$table->foreign('parent_id')
				->references('id')->on('medical_history_references')
				->onDelete('cascade')
				->onUpdate('cascade');
			$table->foreign('child_id')
				->references('id')->on('medical_history_references')
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
        Schema::dropIfExists('medical_history_references');
    }
}
