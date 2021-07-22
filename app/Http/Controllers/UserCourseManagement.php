<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Courses;
use App\Models\UserSubscriptions;
use App\Models\CourseVideo;
use App\Models\CompletedCourse;
use App\Models\UserVideos;
use App\Models\LikeDislikeCourse;
use App\Models\CourseComment;

class UserCourseManagement extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function getCourses(){
        if($this->checkUserSubscriptionValidity(Auth::id()))
        {
            
            $courses = Courses::with('authorName')->where('status', '1')->get();

            return view('user.myclass', ['user' => Auth::user(), 'courses' => $courses]);
        }
        else
        {
            return redirect('/subscriptions');
        }
        
    }
    public function watchCourse($encryptedCourseId, $videoId = null)
    {
        $userId = Auth::id();
        if($this->checkUserSubscriptionValidity(Auth::id()))
        {
            dd('in if');
            $courseId = Crypt::decryptString($encryptedCourseId);
            $courseVideos = CourseVideo::with('getCourse')
                                    ->where('courseId', $courseId)
                                    ->where('status', '1')
                                    ->orderBy('videoOrder')
                                    ->get();

            if($videoId != null){
                $videoToBeWatched = CourseVideo::where('courseId', $courseId)
                                            ->where('status', '1')
                                            ->where('id',  $videoId)->first();
                
                return view('user.watchCourse', ['videoToBeWatched' => $videoToBeWatched, 'courseVideos' => $courseVideos, ]);
            }

            //these ids is used to check which video user has watched
            $videoIds = CourseVideo::where('courseId', $courseId)->get('id')->toArray();

            $userVideo = UserVideos::with('videoDetails')->where('userId', $userId)
                                    ->whereIn('videoId', $videoIds)
                                    ->orderByDesc('videoId')->first();

            

            if($userVideo == null){
                
                
                $videoToBeWatched = CourseVideo::where('courseId', $courseId)
                                                ->where('status', '1')
                                                ->orderBy('videoOrder')
                                                ->first();
                //dd($videoDetails);

                $videoToBeWatched->courseStatus = 'new';
            } 
            else if($userVideo->status == 1)
            {
                $videoOrder = CourseVideo::where('courseId', $courseId)
                                            ->where('id', $userVideo->videoId)->get('videoOrder');
                
                $nextVideoOrder = $videoOrder[0]->videoOrder + 1;
                $videoToBeWatched = CourseVideo::where('courseId', $courseId)
                                            ->where('status', '1')
                                            ->where('videoOrder',  $nextVideoOrder)->first();
                

                if($videoToBeWatched == null){
                    dd('You have completed this course');
                }
                else
                {
                    $videoToBeWatched->courseStatus = 'next';
                }
                //dd($videoDetails);
            }
            else if($userVideo->status == 0){
                $videoToBeWatched = CourseVideo::where('id', $userVideo->videoId)
                                            ->where('status', '1')
                                            ->first();
                $videoToBeWatched->status = 'paused';
                $videoToBeWatched->time = $userVideo->time;
            }

            //if user has to start from begining
            
            //dd($courseVideos);
            return view('user.watchCourse', ['videoToBeWatched' => $videoToBeWatched, 'courseVideos' => $courseVideos, ]);
        }
        else {
            return redirect('/subscriptions');
        }
    }
    public function updateUserVideoStatus(Request $request){
        $systemVideoId = Crypt::decryptString($request->systemVideoId);

        //if the video is paused
        if($request->status == 0){
            //checking if entry for the same video exists
            if(UserVideos::where('videoId', $systemVideoId)->where('userId', Auth::id())->exists()){
                UserVideos::where('videoId', $systemVideoId)
                            ->where('userId', Auth::id())
                            ->update([
                                'time' => $request->time,
                                'status' => $request->status
                            ]);
            }
            else {
                UserVideos::create([
                    'userId' => Auth::id(),
                    'videoId' => $systemVideoId,
                    'time' => $request->time,
                    'status' => $request->status
                ]);
            }
            $response = array('message' => 'videoStatusUpdated');
        }
        else if($request->status == 1)  //if video is completed
        {
            //to change the status to 1
            UserVideos::where('videoId', $systemVideoId)
                        ->where('userId', Auth::id())
                        ->update([
                            'time' => $request->time,
                            'status' => $request->status
                        ]);

            $courseId = Crypt::decryptString($request->courseId);

            $videoIds = CourseVideo::where('courseId', $courseId)->pluck('id')->toArray();

            //get all the completed videos of course, user is currently watching
            $studentWatchedVideos = UserVideos::join('course_videos', 'user_videos.videoId', '=', 'course_videos.id')   
                                                ->where('course_videos.courseId', $courseId)
                                                ->where('user_videos.userId', Auth::id())
                                                ->where('user_videos.status', '1')
                                                ->pluck('user_videos.videoId')->toArray();
            
            //this is to check if user has watched all the videos of the course. Then shift it ot complted course
            if(empty(array_diff($videoIds, $studentWatchedVideos))){   

                UserVideos::where('userId', Auth::id())
                                    ->whereIn('videoId', $videoIds)
                                    ->delete();

                if(CompletedCourse::where('userId', Auth::id())->where('courseId', $courseId)->exists()){
                    CompletedCourse::where('userId', Auth::id())
                                    ->where('courseId', $courseId)
                                    ->update([
                                        'userId' => Auth::id(),
                                        'courseId' => $courseId
                                    ]);
                } else {
                    CompletedCourse::create([
                        'userId' => Auth::id(),
                        'courseId' => $courseId
                    ]);
                }
                $response =  array('message' => 'courseCompleted');
            }
            else {
                $response =  array('message' => 'videoEnded');
            }
        }
        return json_encode($response);
    }
    public function likeDislikeCourse(Request $request){
        $courseId = Crypt::decryptString($request->courseId);
        $type = $request->type;

        if(LikeDislikeCourse::where('userId', Auth::id())->where('courseId', $courseId)->exists()){
            LikeDislikeCourse::where('userId', Auth::id())
                                ->where('courseId', $courseId)
                                ->delete();
        } else {
            LikeDislikeCourse::create([
                                    'userId' => Auth::id(),
                                    'courseId' => $courseId
                                ]);
        }
        echo $type;
    }
    public function commentCourse(Request $request){
        $rules = [
            'courseId' => 'required',
            'comment' => 'required|string',
        ];

        $validator = Validator::make($request->all(), $rules, $messages = [
            'courseId.required' => 'Invalid Request'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $courseId = Crypt::decryptString($request->courseId);

        CourseComment::create([
            'userId' => Auth::id(),
            'courseId' => $courseId,
            'comment' => $request->comment
        ]);

        return back()->with('status', 'Comment Posted Successfully');

    }
}
