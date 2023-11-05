<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_data', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->unsignedBigInteger('complaint_id');
			$table->unsignedBigInteger('parent_id')->nullable();
			$table->unsignedBigInteger('child_id')->nullable();
            $table->string('type')->nullable();
			$table->string('name')->nullable();
			$table->string('description')->nullable();
			$table->longText('value')->nullable();
			$table->longText('sub_value')->nullable();
			$table->unsignedBigInteger('created_by')->nullable();
			$table->unsignedBigInteger('updated_by')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable();
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('complaint_id')
				->references('id')->on('complaint')
				->onDelete('cascade')
				->onUpdate('cascade');
			$table->foreign('parent_id')
				->references('id')->on('complaint_data')
				->onDelete('cascade')
				->onUpdate('cascade');
			$table->foreign('child_id')
				->references('id')->on('complaint_data')
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
        Schema::dropIfExists('complaint_data');
    }
}
