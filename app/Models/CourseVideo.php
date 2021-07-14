<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseVideo extends Model
{
    use HasFactory;
    protected $fillable = ['courseId', 'name','description', 'videoUrl', 'status', 'videoThumbnil', 'videoOrder'];

    public function getCourse()
    {
        return $this->hasOne(Courses::class, 'id', 'courseId');
    }
}
