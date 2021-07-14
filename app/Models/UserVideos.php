<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVideos extends Model
{
    use HasFactory;

    protected $fillable = ['userId', 'videoId', 'status', 'time'];

    public function videoDetails()
    {
        return $this->belongsTo(CourseVideo::class, 'videoId');
    }
}
