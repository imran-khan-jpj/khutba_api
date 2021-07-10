<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Explanation extends Model
{
    use HasFactory;
    protected $fillable = ['lesson_id', 'explanation'];

    public function lesson(){
        return $this->belongsTo(\App\Models\Lesson::class);
    }

    public function replies(){
        return $this->hasMany(\App\Models\Reply::class)->with('answer_reply');
    }
}
