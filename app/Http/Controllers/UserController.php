<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Countries;
use App\Models\User;
use App\Models\Courses;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function sendVerificationOtp()
    {
        $user = Auth::user();
        //dd($user);
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://2factor.in/API/V1/".config('custom.2FactorApiKey')."/SMS/".$user->phoneNo."/AUTOGEN",
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
        return redirect('/otp-verifcation-form')->with('sessionId', $data->Details);
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
        $data = User::where('id', Auth::id())
                ->update(['phoneVerified' => '1']);
        $user = Auth::user();
        $user->phoneVerified = '1';
        $user->save();
        }
        $request->session()->forget('sessionId');
        $request->session()->save();
        return redirect('/dashboard')->with('status', 'Phone No. Verified Successfully');
    }
    public function dashboard(){
        $user = Auth::user();
        $popularCourses = Courses::with('authorName')->where('status', '1')->inRandomOrder()->limit(2)->get();
        //dd($popularCourses);

        return view('user.dashboard', ['user' => $user, 'popularCourses' => $popularCourses]);
        //dd($user);
        //$decryptedUserId = Crypt::decryptString($userId);
    }
    public function viewProfile(){
        $user = Auth::user();
        $countries = Countries::all();
        $countryName = Countries::where('countryCode', $user->location)->first();
        return view('user.viewProfile', ['user' => $user, 'countries' => $countries, 'countryName'=> $countryName]);
    }
    public function updateUser(Request $request)
    {
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

        $path = (Auth::user()->imgPath == null) ? null : Auth::user()->imgPath;

        if($request->has('profileImg'))
        {
            $userImgPath = Auth::user()->imgPath;
            if($userImgPath != null)
            {
                Storage::disk('public')->delete($userImgPath);
            }
            $path = $request->file('profileImg')->store('avatars', 'public');
        }

        User::where('id', Auth::id())
                ->update(['imgPath' => $path,
                          'firstName' => $request->firstName,
                          'lastName' => $request->lastName,
                          'email' => $request->email,
                          'phoneNo' => '+'.$request->dialCode.$request->phoneNo,
                          'location' => $request->location,
                          'dialCode' => $request->dialCode ]);     //updating the login user

        $user = Auth::user();
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        $user->phoneNo = '+'.$request->dialCode.$request->phoneNo;
        $user->location = $request->location;
        $user->dialCode = $request->dialCode;
        $user->imgPath = $path;
        $user->save();    //updating the login session

        return back()->with('status', 'User Data Updated');
    }

    public function userSettings(){
        $user = Auth::user();
        return view('user.settings', ['user' => $user]);
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

        $user = Auth::user();

        if (!Hash::check($request->currentPassword, $user->password)) {
            return back()->with('error', 'Current password does not match!');
        }

        User::where('id', Auth::id())->update([
            'password' => Hash::make($request->password)
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password successfully changed!');
    }
}
