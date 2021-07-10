<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Questionaire extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'title', 'user_id', 'religion'];

    public function course(){
        return $this->belongsTo(\App\Models\Course::class);
    }

    public function questionaire_questions(){
        return $this->hasMany(\App\Models\QuestionaireQuestion::class);
    }

    public function users(){
        return $this->belongsToMany(\App\Models\User::class);
    }
}
