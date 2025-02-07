<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';
    protected $fillable = ['name', 'questions'];

    // Add the following cast
    protected $casts = [
        'questions' => 'array',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
