<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = ['further_id', 'answer'];

    public function further(){
        return $this->belongsTo(\App\Models\Answer::class);
    }
}
