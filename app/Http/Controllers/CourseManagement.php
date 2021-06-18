<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Vimeo\Laravel\Facades\Vimeo;

class CourseManagement extends Controller
{
    public function uploadVideo(){
        Vimeo::upload('assets/foo.mp4');
    }
}
