<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SecurityQuestion;
use App\Models\CreditPoints;
use App\Models\Countries;
use App\Models\Subscription;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function dashboard(){
        return view('admin.dashboard');
    }

    public function users(){
        $users = User::with('country')->get();
        return view('admin.users', ['users' => $users]);
    }
    public function changeUserStatus(Request $request){
        $updatedUserStatus = ($request->userStatus == 0) ? 1 : 0;
        $userId = explode('_', $request->userId);  //since user id form frontend is with '_'. For eg user_1

        $user = User::findOrFail($userId[1]);
        $user->status = $updatedUserStatus;
        $user->save();
    }
    public function editUser($userId){
        $decryptedUserId = Crypt::decryptString($userId);
        $userDetails = User::with('securityQuestionDetail')->with('country')->findOrFail($decryptedUserId);
        //dd($userDetails);
        $securityQuestions = SecurityQuestion::all();
        $countries = Countries::all();
        //dd($userDetails);

        return view('admin.editUser', ['userDetails' => $userDetails, 'securityQuestions' => $securityQuestions, 'countries' => $countries]);
    }
    public function adminEditUser(Request $request)
    {
        $rules = [
            'userId' => 'required',
            'firstName' => 'required|string|max:180',
            'lastName' => 'required|string|max:180',
            'email' => 'required|email',
            'location' => 'required|string',
            'phoneNo' => 'required|max:15|string',
            'age' => 'required|numeric|digits_between:0,100',
            'securityQuestion' => 'required|numeric',
            'securityAnswer' => 'required|string',
            'gender' => 'required|digits_between:0,2',
            'dialCode' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages = [
            'securityQuestion.numeric' => 'Invalid Security Question Selected',
            'gender.digits_between' => 'Invalid Gender Selected',
            'userId.required' => 'Invalid Request',
            'dialCode.required' => 'Invalid request'
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $userId = Crypt::decryptString($request->userId);

        User::where('id', $userId)
                ->update(['firstName' => $request->firstName,
                          'lastName' => $request->lastName,
                          'email' => $request->email,
                          'phoneNo' => '+'.$request->dialCode.$request->phoneNo,
                          'location' => $request->location,
                          'dialCode' => $request->dialCode,
                          'age' => $request->age,
                          'gender' => $request->gender,
                          'securityQuestion' => $request->securityQuestion,
                          'securityAnswer' => $request->securityAnswer ]); 

        return back()->with('status', 'User Data Updated');
    }
    public function viewSubscriptions(){
            $subscriptions = Subscription::all();
            return view('admin.subscriptions', ['subscriptions' => $subscriptions]);
    }
    public function addSubscription(Request $request){
        if($request->name != null){
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:180',
                'validity' => 'required|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'description' =>'required'
            ]);
            if ($validator->fails()) {
                return back()
                        ->withErrors($validator)
                        ->withInput();
            }

            Subscription::create([
                'name' => $request->name,
                'validity' => $request->validity,
                'price' => $request->price,
                'description' => $request->description
            ]);

            return back()->with('status', 'Subscription Added Successfull');

        } else {
            return view('admin.subscriptionForm');
        }
    }
    public function editSubscription($encryptedSubscriptionId){
        try {
            $subscriptionId = Crypt::decryptString($encryptedSubscriptionId);
        } catch (DecryptException $e) {
            abort(419);
        }

        $subscriptionDetails = Subscription::findOrFail($subscriptionId);
        return view('admin.editSubscription', ['subscriptionDetails' => $subscriptionDetails]);        
    }
    public function updateSubscription(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'subscriptionId' => 'required',
                'name' => 'required|string|max:180',
                'validity' => 'required|numeric|min:0',
                'price' => 'required|numeric|min:0',
                'description' =>'required'
            ]);
            if ($validator->fails()) {
                return back()
                        ->withErrors($validator)
                        ->withInput();
            }

            try {
                $subscriptionId = Crypt::decryptString($request->subscriptionId);
            } catch (DecryptException $e) {
                abort(419);
            }
            Subscription::where('id', $subscriptionId)
                            ->update([
                                'name' => $request->name,
                                'validity' => $request->validity,
                                'price' => $request->price,
                                'description' => $request->description
                            ]);
            
            return back()->with('status', 'Subscription Updated Successfull');
    }
    public function settings()
    {
        $creditPoints = CreditPoints::first();
        return view('admin.creditPointForm', ['creditPoints' => $creditPoints]);
    }
    public function setCreditPoints(Request $request){
        $validator = Validator::make($request->all(), [
            'creditPoints' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            return back()
                    ->withErrors($validator)
                    ->withInput();
        }

        CreditPoints::where('id', 1)
                      ->update(['creditPoints' => $request->creditPoints]);

        return back()->with('status', 'Credit Points Updated Successfully');

    }
}
