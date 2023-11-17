<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsFeedFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_feed_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('news_feed_id');
            $table->unsignedBigInteger('file_attachment_id');
            $table->string('file_type')->nullable();
            $table->timestamps();

            $table->foreign('news_feed_id')
				 ->references('id')->on('news_feeds')
				 ->onUpdate('cascade')
				 ->onDelete('cascade');

            $table->foreign('file_attachment_id')
				 ->references('id')->on('file_attachments')
				 ->onUpdate('cascade')
				 ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_feed_files');
    }
}
