<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courses;
use App\Mail\ContactForm;
use App\Mail\ContactFormAdmin;
use App\Mail\NewsLetterMail;
use App\Models\User;
use App\Models\Categories;
use App\Models\ContactUs;
use App\Models\NewsLetter;
use App\Models\Page;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use DB;

class MainController extends Controller
{
    public function index(){
        $trendingCourses = Courses::where('courseType', 3)
                                    ->where('status', '1')
                                    ->orderByDesc('id')
                                    ->limit(3)
                                    ->get();
        $recentCourses = Courses::where('courseType', 1)
                                    ->where('status', '1')
                                    ->orderByDesc('id')
                                    ->limit(3)
                                    ->get();

        $suggestedCourses = Courses::where('courseType', 2)
                                    ->where('status', '1')
                                    ->orderByDesc('id')
                                    ->limit(3)
                                    ->get();

        return view('index', ['trendingCourses' => $trendingCourses, 'recentCourses' => $recentCourses, 'suggestedCourses' => $suggestedCourses]);
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

        $courseDetails = Courses::with('authorName')->with('getVideos')->with('getLikes')->findOrFail($courseId);

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
    public function contactUs(Request $request){

        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string',
            'email' => 'required|email',
            'formQuery' => 'required'
        ]);

        if($validator->fails()){
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        $contactDetails = ContactUs::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'query' => $request->formQuery,
        ]);
       
        Mail::to($request->email)->send(new ContactForm($contactDetails));
        //dd(env('Admin_Mail'));
        Mail::to(env('Admin_Mail'))->send(new ContactFormAdmin($contactDetails));
        return back()->with('status', 'Form has been submiited. We will get back to you soon');
    }

    public function subscribe(Request $request){
        $validator = Validator::make($request->all(), [
            'newsLetterEmail' => 'required|email|unique:news_letters,email'
        ]);

        if($validator->fails()){
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        $newsLetter = NewsLetter::create([
            'email' => $request->newsLetterEmail
        ]);

        Mail::to($request->newsLetterEmail)->send(new NewsLetterMail($newsLetter));

        return back()->with('status', 'Subscribed Successfully');
    }

    public function getPage($pageLink){
        if(Page::where('pageUrl', $pageLink)->where('status', '1')->exists())  // if qa exsists
        {
            $pageDetail = Page::where('pageUrl', $pageLink)->first();
            return view('customPage', ['pageDetail' => $pageDetail]);
            
        }
        else   // if nothings exsists show qa
        {
            abort(404);
        }
    }
}
