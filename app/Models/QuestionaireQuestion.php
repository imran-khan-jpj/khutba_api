<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionaireQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'questionaire_id', 'question', 'correct_answer', 'incorrect_answer1', 'incorrect_answer2', 'incorrect_answer3'];

    public function course(){
        return $this->belongsTo(\App\Models\Course::class);
    }

    public function questionaire(){
        return $this->belongsTo(\App\Models\Questionaire::class);
    }
}
