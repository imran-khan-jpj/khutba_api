<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];


    public function users(){
        return $this->belongsToMany(\App\Models\User::class);
    }
    

    public function lessons(){
        return $this->hasMany(\App\Models\Lesson::class)->with('explanation');
    }

    public function questionaires(){
        return $this->hasMany(\App\Models\Questionaire::class)->with('questionaire_questions', 'course');
    }
}
