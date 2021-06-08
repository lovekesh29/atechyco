<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

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
        $users = User::all();
        //dd(config('custom.gender.2'));
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
        $userDetails = User::findOrFail($decryptedUserId);
        dd($userDetails);

        return view('admin.editUser', ['userDetails' => $userDetails]);
    }
    
    

    
}
