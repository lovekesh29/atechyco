<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Countries;
use App\Models\User;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:guru', 'verified']);
    }
    public function dashboard(){
        $guru = Auth::guard('guru')->user();

        return view('user.dashboard', ['guru' => $guru]);
        //dd($user);
        //$decryptedUserId = Crypt::decryptString($userId);
    }
}
