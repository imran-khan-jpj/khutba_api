<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Course;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'content', 'content_for'];

    public function course(){
        return $this->belongsTo(\App\Models\Course::class);
    }

    public function explanation(){
        return $this->hasOne(\App\Models\Explanation::class)->with('replies', 'replies.answer_reply');
    }
}
