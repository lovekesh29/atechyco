<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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
        $courses = Courses::with('authorName')->paginate(10);
        return view('admin.courses', ['courses' => $courses]);
    }
    public function uploadCourseView(Request $request)
    {
        $guru = Guru::all();
        return view('admin.uploadCourses', ['gurus' => $guru]);
    }
    public function editCourseView($encryptedCourseId){
        $courseId = Crypt::decryptString($encryptedCourseId);
        $courseDetail = Courses::with('authorName')->where('id', $courseId)->first();
        $guru = Guru::all();
        //session(['editCourse' => true]);
        return view('admin.editCourses', ['courseDetail' => $courseDetail, 'gurus' => $guru]);
    }
    public function uploadCourse(Request $request){
        $rules = [
            'title' => 'required',
            'author' => 'required|numeric',
            'description' => 'required',
            'videoFiles' => 'required'
        ];
        
        $validator = Validator::make($request->all(), $rules, $message =[
            'author.numeric' => 'Invalid Author Selected'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        $insertedCourseData = Courses::create([
            'status' => '1',
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description
        ]);

        if($request->has('videoFiles'))
        {
            $i = 0;
            foreach($request->file('videoFiles') as $file)
            {
                $uploadVideodata[$i]['videoUrl'] = Vimeo::upload($file); 
                $uploadVideodata[$i]['courseId'] = $insertedCourseData->id;
                $uploadVideodata[$i]['videoOrder'] = $i;
                $uploadVideodata[$i]['status'] = '1';
                $i++;
            }
            CourseVideo::insert($uploadVideodata);
        }
        return back()->with('successfull', 'Course Uploaded Successfull');
    }
    public function updateCourse(){
        $rules = [
            'courseId' => 'required',
            'title' => 'required',
            'author' => 'required|numeric',
            'description' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules, $message =[
            'author.numeric' => 'Invalid Author Selected',
            'courseId.required' => 'Invalid Request Sent'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        $courseId = Crypt::decryptString($request->courseId);
        Courses::where('id', $courseId)
        ->update([
            'title' => $request->title,
            'author' => $request->author,
            'description' => $request->description,
        ]);
        if($request->has('videoFiles'))
        {
            $videoOrder = CourseVideo::where('courseId', $courseId)->max('videoOrder');
            $i = 0;
            $newVideoOrder = $videoOrder+1;
            foreach($request->file('videoFiles') as $file)
            {
                $uploadVideodata[$i]['videoUrl'] = Vimeo::upload($file); 
                $uploadVideodata[$i]['courseId'] = $courseId;
                $uploadVideodata[$i]['videoOrder'] = $newVideoOrder;
                $uploadVideodata[$i]['status'] = '1';
                $i++;
                $newVideoOrder++;
            }
            CourseVideo::insert($uploadVideodata);
        }
        return back()->with('successfull', 'Course Uploaded Successfull');

    }
    public function viewVideos($encryptedCourseId){
        $courseId = Crypt::decryptString($encryptedCourseId);

        $videosData = CourseVideo::with('getCourse')->where('courseId', $courseId)->orderBy('videoOrder')->paginate(10);
        
        return view('admin.viewVideos', ['videosData' => $videosData]);
    }
    public function videoDetailsForm($encryptedVideoUrl){
        $videoUrl = Crypt::decryptString($encryptedVideoUrl);

        $videoDetails = CourseVideo::where('videoUrl', $videoUrl)->first();
        return view('admin.videoMeta', ['videoDetails' => $videoDetails]);

        // $response = Http::withToken(config('vimeo.connections.main.access_token'))->accept('application/vnd.vimeo.*+json;version=3.4')->get('https://api.vimeo.com'.$videoUrl);

        //dd($response);
    }
    public function uploadVideoMeta(Request $request){
        $rules = [
            'videoUrl' => 'required',
            'name' => 'required|string',
            'description' => 'required',
            'videoThumbnil' => 'image',
            'videoOrder' => 'required|numeric'
        ];
        $validator = Validator::make($request->all(), $rules, $message =[
            'videoUrl.required' => 'Invalid request'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $videoUrl = Crypt::decryptString($request->videoUrl);

        $videoDetails = CourseVideo::where('videoUrl', $videoUrl)->first();

        Vimeo::request($videoUrl, array(
            'name' => $request->name,
            'description' => $request->description,
          ), 'PATCH');

        $path = ($videoDetails->videoThumbnil == null ? null : $videoDetails->videoThumbnil);
        if($request->has('videoThumbnil'))
        {
            $videoThumbnil = $videoDetails->videoThumbnil;
            if($videoThumbnil != null)
            {
                Storage::disk('public')->delete($videoThumbnil);
            }
            $path = $request->file('videoThumbnil')->store('videoThumbnils', 'public');
        }

        CourseVideo::where('videoUrl', $videoUrl)
                ->update(['name' => $request->name,
                          'description' => $request->description,
                          'videoThumbnil' => $path,
                          'videoOrder' => $request->videoOrder]); 

        return back()->with('status', 'Video Meta Updated successfully');
    }
    public function changeCourseStatus(Request $request){
        $courseId = Crypt::decryptString($request->courseId);
        $updatedCourseStatus = ($request->courseStatus == 0) ? '1' : '0';

        $course = Courses::findOrFail($courseId);
        $course->status = $updatedCourseStatus;
        $course->save();

        CourseVideo::where('courseId', $courseId)
                    ->update([
                        'status' => $updatedCourseStatus
                    ]);
    }
}
