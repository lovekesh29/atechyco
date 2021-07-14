<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;

class MainController extends Controller
{
    public function index(){
        $courses = Courses::latest()->limit(3)->get();

        return view('index');
    }
    public function viewCourse($courseName){

    }
}
