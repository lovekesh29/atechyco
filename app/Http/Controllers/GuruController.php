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

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:guru', 'verified']);
    }
    public function dashboard(){
        $guru = Auth::guard('guru')->user();

        return view('guru.dashboard', ['guru' => $guru]);
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

        $path = null;

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
}
