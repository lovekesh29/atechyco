<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Vimeo\Laravel\Facades\Vimeo;
use App\Models\Guru;
use App\Models\Courses;
use App\Models\CourseVideo;

class CourseManagement extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function getCourses()
    {
        $courses = Courses::with('authorName')->get();
        return view('admin.courses', ['courses' => $courses]);
    }
    public function uploadCourseView(){
        $guru = Guru::all();
        return view('admin.uploadCourses', ['gurus' => $guru]);
        
    }
    public function uploadCourse(Request $request){

        $rules = [
            'title' => 'required',
            'author' => 'required|numeric',
            'description' => 'required',
            'videoFiles' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules, $message =[
            'author.numeric' => 'Invalid Author Selected',
            'dialCode.required' => 'Invalid request'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        
        // 
        $insertedCourseData = Courses::create([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
        ]);
        if($request->has('videoFiles'))
        {
            $i = 0;
            foreach($request->file('videoFiles') as $file)
            {
                $uploadVideodata[$i]['videoUrl'] = Vimeo::upload($file); 
                $uploadVideodata[$i]['courseId'] = $insertedCourseData->id;
                $i++;
            }
        }
        CourseVideo::insert($uploadVideodata);

        return back()->with('successfull', 'Course Uploaded Successfull');
    }
    public function viewVideos(){
        $videosData = CourseVideo::with('getCourse')->get();
        
        return view('admin.viewVideos', ['videosData' => $videosData]);
    }
}
