<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quiz';
    protected $fillable = ['name', 'questions'];

    // Cast the 'questions' attribute to an array
    protected $casts = [
        'questions' => 'array',
    ];
}
