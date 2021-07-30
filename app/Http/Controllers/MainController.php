<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use DB;

class MainController extends Controller
{
    public function index(){
        $courses = Courses::latest()->limit(3)->get();
        return view('index');
    }
    public function viewCourses(Request $request){
        if(isset($request->serachCourse)){
            $courses = Courses::with('getLikes')->with('getVideos')->with('getComments')
                            ->where('title', 'like', '%'.$request->serachCourse.'%')
                            ->orWhere('description', 'like', '%'.$request->serachCourse.'%')
                            ->paginate(10);
                            
            if($courses->total() == 0){
                $courses = Courses::with('getLikes')->with('getVideos')->with('getComments')->paginate(10);
                $request->session()->flash('warning', 'No courses were found');
            }
        } else if(isset($request->sub_cat)){
            $subCatId = Crypt::decryptString($request->sub_cat);
            $courses = Courses::with('getLikes')->with('getVideos')->with('getComments')->where('courseSubCat', $subCatId)->paginate(10);
        } else {
            $courses = Courses::with('getLikes')->with('getVideos')->with('getComments')->paginate(10);
        }
        return view('course-list', ['courses' => $courses]);
    }
    public function singleCourse($encryptedCourseId){
        $courseId = Crypt::decryptString($encryptedCourseId);

        $courseDetails = Courses::with('authorName')->with('getVideos')->with('getComments')->with('getLikes')->findOrFail($courseId);

        $courseDetails->setRelation('getComments', $courseDetails->getComments()->paginate(4));
        foreach($courseDetails->getComments as $comment)
        {
            $user = User::findOrFail($comment->userId);
            $comment->userFirstName = $user->firstName;
            $comment->userLastName = $user->lastName;
            $comment->userImage = $user->imgPath;
        }
        
        return view('course-single', ['courseDetails' => $courseDetails]);
    }
}
