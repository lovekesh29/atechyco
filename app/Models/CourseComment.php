<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseComment extends Model
{
    use HasFactory;

    protected $fillable = ['courseId', 'userId', 'comment', 'status'];

    public function getUser(){
        return $this->belongsTo(User::class, 'userId');
    }
    public function getCourse(){
        return $this->belongsTo(Courses::class, 'courseId');
    }
}
