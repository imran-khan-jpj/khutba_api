<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reply_id');
            $table->string('answer_reply');
            $table->string('answer_by');
            $table->timestamps();

            $table->foreign('reply_id')->references('id')->on('replies')->onDelete('cascade')->onupdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answer_replies');
    }
}
