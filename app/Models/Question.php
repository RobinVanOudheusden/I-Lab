<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';
    protected $fillable = ['question', 'answers', 'quiz_id', 'type'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}


