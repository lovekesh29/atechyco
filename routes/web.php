<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\CourseManagement;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserAuth;
use App\Http\Controllers\GuruAuth;
use App\Models\SecurityQuestion;
use App\Models\Countries;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

//verify route
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

//route after verification
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

//resend verification link
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


//Guru Email Verification

//route after verification
Route::get('guru/email/verify', function () {
    return view('auth.guru-verify-email');
})->middleware('auth:guru')->name('verification.notice');
Route::get('/guru/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/guru/dashboard');
})->middleware(['auth:guru', 'signed'])->name('verification.guruVerify');
//resend verification link
Route::post('guru/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth:guru', 'throttle:6,1'])->name('verification.guruSend');





Route::get('/sign-up', function () {
    $securityQuestions = SecurityQuestion::all();
    $countries = Countries::all();
    return view('signup', ['securityQuestions' => $securityQuestions, 'countries' => $countries]);
});
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/sign-up', [UserAuth::class, 'register']);
Route::post('/login', [UserAuth::class, 'authenticate']);
Route::get('/logout', [UserAuth::class, 'logout']);

Route::get('/dashboard', [UserController::class, 'dashboard']);
Route::get('/view-profile', [UserController::class, 'viewProfile']);
Route::post('/update-user', [UserController::class, 'updateUser']);


Route::prefix('guru')->group(function () {
    Route::get('/sign-up', function () {
        $securityQuestions = SecurityQuestion::all();
        $countries = Countries::all();
        return view('guruSignup', ['securityQuestions' => $securityQuestions, 'countries' => $countries]);
    });
    Route::post('/sign-up', [GuruAuth::class, 'register']);
    Route::get('/dashboard', [GuruController::class, 'dashboard']);
    Route::get('/login', function () {
        return view('guruLogin');
    })->name('guru.login');
    Route::post('/login', [GuruAuth::class, 'authenticate']);
    Route::get('/logout', [GuruAuth::class, 'logout']);
});




Route::prefix('admin')->group(function () {
    Route::view('/', 'admin.login')->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'authenticate']);
    Route::get('/logout', [AdminLoginController::class, 'logout']);

    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/user', [AdminController::class, 'users']);
    Route::get('/edit-user/{userId}', [AdminController::class, 'editUser']);
    Route::post('/change-user-status', [AdminController::class, 'changeUserStatus']);
    Route::post('/edit-user', [AdminController::class, 'adminEditUser']);
    Route::get('/upload-video', [CourseManagement::class, 'uploadVideo']);
});



