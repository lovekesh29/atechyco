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
}
