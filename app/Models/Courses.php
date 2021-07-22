<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    protected $fillable = ['title', 'author', 'description', 'status'];

    public function authorName()
    {
        return $this->belongsTo(Guru::class, 'author');
    }
    public function getLikes()
    {
        return $this->hasMany(LikeDislikeCourse::class, 'courseId');
    }
    public function getVideos()
    {
        return $this->hasMany(CourseVideo::class, 'courseId');
    }
    public function getComments()
    {
        return $this->hasMany(CourseComment::class, 'courseId');
    }
}
