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

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    public function dashboard(){
        $user = Auth::user();

        return view('user.dashboard', ['user' => $user]);
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

        $path = null;

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
        return view('guru.settings', ['user' => $user]);
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
