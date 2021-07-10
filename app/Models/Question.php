<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'question', 'answer', 'answer_by'];

    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }

    public function furthers(){
        return $this->hasMany(\App\Models\Further::class)->with('answer');
    }
}
