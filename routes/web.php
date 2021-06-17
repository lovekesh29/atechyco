<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserAuth;
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




Route::view('/admin', 'admin.login')->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'authenticate']);
Route::get('/admin/logout', [AdminLoginController::class, 'logout']);

Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('/admin/user', [AdminController::class, 'users']);
Route::get('/admin/edit-user/{userId}', [AdminController::class, 'editUser']);
Route::post('/admin/change-user-status', [AdminController::class, 'changeUserStatus']);
Route::post('/admin/edit-user', [AdminController::class, 'adminEditUser']);

