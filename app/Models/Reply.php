<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    protected $fillable = ['reply', 'explanation_id', 'user_name'];

    public function explanation(){
        return $this->belongsTo(\App\Models\Explanation::class);
    }

    public function answer_reply(){
        return $this->hasOne(\App\Models\AnswerReply::class);
    }
}
