<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_attachments', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('subject')->nullable();
			$table->string('mime_type')->nullable();
			$table->string('file_type')->nullable();
			$table->string('file_extension')->nullable();
			$table->string('file_path');
			$table->string('file_name');
			$table->unsignedBigInteger('created_by')->nullable();
			$table->unsignedBigInteger('updated_by')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
		DB::statement("ALTER TABLE `file_attachments` ADD COLUMN `data` LONGBLOB DEFAULT NULL AFTER `file_name`");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_attachments');
    }
}
