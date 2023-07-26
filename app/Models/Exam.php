<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    function course()
    {
        return $this->belongsTo(Course::class);
    }

    function questions()
    {
        return $this->hasMany(Question::class);
    }

    function users()
    {
        return $this->belongsToMany(User::class);
    }
}