<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    protected $fillable = ['title', 'author', 'description', 'status', 'courseType', 'courseSubCat'];

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
    public function getCurrentView(){
        return $this->hasManyThrough(UserVideos::class, CourseVideo::class, 'courseId', 'videoId');
    }
    public function getCompletedCourses(){
        return $this->hasMany(CompletedCourse::class, 'courseId');
    }
    public function getCourseSubCat(){
        return $this->belongsTo(SubCategories::class, 'courseSubCat');
    }
}
