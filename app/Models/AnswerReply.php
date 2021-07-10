<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerReply extends Model
{
    use HasFactory;

    protected $fillable= ['reply_id', 'answer_reply', 'answer_by'];

    public function reply(){
        return $this->belongsTo(\App\Models\Reply::class);
    }
}
