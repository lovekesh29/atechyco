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
use App\Models\UserVideos;

class UserCourseManagement extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function watchCourse($encryptedCourseId)
    {
        $userId = Auth::id();

        $userSubscription = UserSubscriptions::where('userId', $userId)->latest()->first();
        
        if($userSubscription != null){
            if($this->checkValidity($userSubscription))
            {
                $courseId = Crypt::decryptString($encryptedCourseId);
                $videoIds = CourseVideo::where('courseId', $courseId)->get('id')->toArray();

                $userVideo = UserVideos::with('videoDetails')->where('userId', $userId)
                                        ->whereIn('videoId', $videoIds)
                                        ->orderByDesc('id')->first();

                
                //if previous video is ended
                if($userVideo->status == 1){
                    $videoOrder = CourseVideo::where('courseId', $courseId)
                                                ->where('id', $userVideo->videoId)->get('videoOrder');
                    
                    $nextVideoOrder = $videoOrder[0]->videoOrder + 1;
                    $nextVideoDetails = CourseVideo::where('courseId', $courseId)
                                                ->where('videoOrder',  $nextVideoOrder)->first();
                    

                    if($nextVideoDetails == null){
                        dd('You have completed this course');
                    }
                    else
                    {
                        $videoDetails = $nextVideoDetails;
                        $videoDetails->videoId = $videoDetails->id;
                        $videoDetails->status = 'next';
                    }
                    //dd($videoDetails);
                }
                else if($userVideo->status == 0){
                    $videoDetails = CourseVideo::where('id', $userVideo->videoId)
                                                ->first();
                    $videoDetails->status = 'paused';
                    $videoDetails->time = $userVideo->time;
                    //dd($videoDetails);
                    
                }

                //if user has to start from begining
                if($userVideo == null){
                    $videoDetails = CourseVideo::where('courseId', $courseId)
                                                ->where('videoOrder', 0)
                                                ->first();

                    $videoDetails->status = 'new';
                    $videoDetails->videoId = $videoDetails->id;
                    //dd($videoDetails);
                }

                return view('user.watchCourse', ['videoDetails' => $videoDetails]);
            }
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
            else{
                UserVideos::create([
                    'userId' => Auth::id(),
                    'videoId' => $systemVideoId,
                    'time' => $request->time,
                    'status' => $request->status
                ]);
            }
        }
        else if($request->status == 1)  //if video is completed
        {
            UserVideos::where('videoId', $systemVideoId)
                            ->where('userId', Auth::id())
                            ->delete();

            UserVideos::create([
                                'userId' => Auth::id(),
                                'videoId' => $systemVideoId,
                                'time' => $request->time,
                                'status' => $request->status
                            ]);
        }
    }
}
