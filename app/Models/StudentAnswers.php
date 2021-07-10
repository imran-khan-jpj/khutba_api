<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswers extends Model
{
    use HasFactory;

    protected $fillable = ['questionaire_question_id', 'questionaire_id', 'user_id', 'question_id','answer'];
    protected $table = "questionaire_question_answers";

    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }
    public function questionaire(){
        return $this->belongsTo(\App\Models\Questionaire::class);
    }
    public function questionaire_question(){
        return $this->belongsTo(\App\Models\QuestionaireQuestion::class);
    }
}
