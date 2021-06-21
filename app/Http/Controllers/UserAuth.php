<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


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
            'age' => 'required|numeric|digits_between:0,100',
            'termsCondition' => 'accepted',
            'dialCode' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules, $messages = [
            'securityQuestion.numeric' => 'Invalid Security Question Selected',
            'gender.digits_between' => 'Invalid Gender Selected',
            'dialCode.required' => 'Invalid request'
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
            'phoneNo' => '+'.$request->dialCode.$request->phoneNo,
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

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()
                ->withErrors([
                    'email' => 'The provided credentials do not match our records or your account may be deactived.',
                ])
                ->withInput();
    }
    public function forgotPassword(Request $request){
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
    public function resetPassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ]);
    
                $user->save();
    
                event(new PasswordReset($user));
            }
        );
    
        //dd($status);
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
    public function logout(Request $request){
        Auth::logout();

        return redirect('/');
    }
}
