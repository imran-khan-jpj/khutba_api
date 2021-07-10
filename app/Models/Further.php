<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Further extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'further'];

    public function question(){
        return $this->belongsTo(\App\Models\Question::class);
    }

    public function answer(){
        return $this->hasOne(\App\Models\Answer::class);
    }
}
