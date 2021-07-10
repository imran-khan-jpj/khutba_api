<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionaireQuestionAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionaire_question_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('questionaire_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('questionaire_question_id');
            $table->string('answer');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('questionaire_id')->references('id')->on('questionaires')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('questionaire_question_id')->references('id')->on('questionaire_questions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionaire_question_answers');
    }
}
