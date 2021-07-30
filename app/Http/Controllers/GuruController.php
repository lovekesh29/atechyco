<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Countries;
use App\Models\Guru;
use App\Models\Courses;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:guru', 'verified']);
    }
    public function sendVerificationOtp()
    {
        $guru = Auth::guard('guru')->user();
        //dd($user);
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://2factor.in/API/V1/".config('custom.2FactorApiKey')."/SMS/".$guru->phoneNo."/AUTOGEN",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        $data =  json_decode($response);
        }
        return redirect('guru/otp-verifcation-form')->with('sessionId', $data->Details);
    }
    public function verifyUserPhone(Request $request)
    {
        $rules = [
            'sessionId' => 'required',
            'otp' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules, $messages = [
            'sessionId.required' => 'Invalid Request Sent'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://2factor.in/API/V1/".config('custom.2FactorApiKey')."/SMS/VERIFY/".$request->sessionId."/".$request->otp,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_POSTFIELDS => "",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            $data =  json_decode($response);
        }

        if($data->Status == "Error"){
            session(['sessionId' => $request->sessionId]);
            $request->session()->flash('Error', $data->Details);
            return back();
        }
        else{
        $data = Guru::where('id', Auth::guard('guru')->id())
                ->update(['phoneVerified' => '1']);
                //dd($data);
        $guru = Auth::guard('guru')->user();
        $guru->phoneVerified = '1';
        $guru->save();
        //dd(Auth::guard('guru')->user());
        }
        $request->session()->forget('sessionId');
        return redirect('guru/dashboard')->with('status', 'Phone No. Verified Successfully');
    }
    public function dashboard(){
        $guru = Auth::guard('guru')->user();

        $guruRecentCourses = Courses::where('author', Auth::guard('guru')->id())->orderByDesc('id')->take(2)->get();
        

        $guruCourseStats = Courses::with('getLikes')->with('getComments')->with('getCurrentView')->with('getCompletedCourses')->where('author', Auth::guard('guru')->id())->get()->toArray();

        return view('guru.dashboard', ['guru' => $guru, 'guruRecentCourses' => $guruRecentCourses, 'guruCourseStats' => $guruCourseStats]);
    }
    public function viewProfile(){
        $guru = Auth::guard('guru')->user();
        $countries = Countries::all();
        $countryName = Countries::where('countryCode', $guru->location)->first();
        return view('guru.viewProfile', ['guru' => $guru, 'countries' => $countries, 'countryName'=> $countryName]);
    }
    public function updateGuru(Request $request)
    {
        //dd($request);
        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:180',
            'lastName' => 'required|string|max:180',
            'email' => 'required|email',
            'location' => 'required|string',
            'phoneNo' => 'required|max:15|string',
            'profileImg' => 'image',
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $path = (Auth::guard('guru')->user()->imgPath == null) ? null : Auth::guard('guru')->user()->imgPath;

        if($request->has('profileImg'))
        {
            $guruImgPath = Auth::guard('guru')->user()->imgPath;
            if($guruImgPath != null)
            {
                Storage::disk('public')->delete($guruImgPath);
            }
            $path = $request->file('profileImg')->store('avatars', 'public');
        }

        Guru::where('id', Auth::guard('guru')->id())
                ->update(['imgPath' => $path,
                          'firstName' => $request->firstName,
                          'lastName' => $request->lastName,
                          'email' => $request->email,
                          'phoneNo' => '+'.$request->dialCode.$request->phoneNo,
                          'location' => $request->location,
                          'dialCode' => $request->dialCode ]);     //updating the login guru

        $guru = Auth::guard('guru')->user();
        $guru->firstName = $request->firstName;
        $guru->lastName = $request->lastName;
        $guru->email = $request->email;
        $guru->phoneNo = '+'.$request->dialCode.$request->phoneNo;
        $guru->location = $request->location;
        $guru->dialCode = $request->dialCode;
        $guru->imgPath = $path;
        $guru->save();    //updating the login session

        return back()->with('status', 'Your Data Updated');
    }
    public function userSettings(){
        $guru = Auth::guard('guru')->user();
        return view('guru.settings', ['guru' => $guru]);
    } 
    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $guru = Auth::guard('guru')->user();

        if (!Hash::check($request->currentPassword, $guru->password)) {
            return back()->with('error', 'Current password does not match!');
        }

        Guru::where('id', Auth::guard('guru')->id())->update([
            'password' => Hash::make($request->password)
        ]);

        $guru->password = Hash::make($request->password);
        $guru->save();

        return back()->with('success', 'Password successfully changed!');
    }
    public function getGuruCourses(){
        $guruCourses = Courses::with('getLikes')->with('getComments')->with('getCurrentView')->with('getCompletedCourses')->where('author', Auth::guard('guru')->id())->paginate(10);

        return view('guru.courses', ['guruCourses' => $guruCourses]);

        //return view('guru.courses', ['guruCourses' => $guruCourses]);
    }
}
