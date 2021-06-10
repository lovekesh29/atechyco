<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserAuth extends Controller
{
    public function register(Request $request){
        $rules = [
            'firstName' => 'required|string|max:180',
            'lastName' => 'required|string|max:180',
            'email' => 'required|email|unique:users',
            'location' => 'required|string',
            'phoneNo' => 'required|max:15|string',
            'password' => 'required|string|confirmed',
            'password_confirmation' => 'required|same:password',
            'securityQuestion' => 'required|numeric',
            'securityAnswer' => 'required|string',
            'gender' => 'required|digits_between:0,2',
            'age' => 'required|numeric',
            'termsCondition' => 'accepted'
        ];
        $validator = Validator::make($request->all(), $rules, $messages = [
            'securityQuestion.numeric' => 'Invalid Security Question Selected',
            'gender.digits_between' => 'Invalid Gender Selected'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $signupArray = array(
            'firstName' => ucwords($request->firstName),
            'lastName' => ucwords($request->lastName),
            'location' => $request->location,
            'phoneNo' => $request->fullPhoneNo,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'securityQuestion' => $request->securityQuestion,
            'securityAnswer' => $request->securityAnswer,
            'gender' => $request->gender,
            'age' => $request->age,
            'status' => 1,
            'dialCode' => $request->dialCode,
        );
		
        $user = User::create($signupArray);
        event(new Registered($user));
        Auth::login($user);
        return redirect()->intended('/dashboard');

    }
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()
                ->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ])
                ->withInput();
    }
    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
