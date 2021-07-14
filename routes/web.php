<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\CourseManagement;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCourseManagement;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserAuth;
use App\Http\Controllers\GuruAuth;
use App\Models\SecurityQuestion;
use App\Models\Countries;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

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



//user forgot password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password', ['action' => url('/forgot-password')]);
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', [UserAuth::class, 'forgotPassword'])->middleware('guest')->name('password.email');

Route::get('/reset-password', function (Request $request) {
    return view('auth.reset-password', ['action' => url('/reset-password'), 'token' => $request->token, 'email' => $request->email]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', [UserAuth::class, 'resetPassword'])->middleware('guest')->name('password.reset');




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








Route::get('/sign-up', function (Request $request) {
    $securityQuestions = SecurityQuestion::all();
    $countries = Countries::all();
    return view('signup', ['securityQuestions' => $securityQuestions, 'countries' => $countries, 'refredBy' => $request->r]);
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
Route::get('/user-settings', [UserController::class, 'userSettings']);
Route::post('/update-password', [UserController::class, 'updatePassword']);
Route::get('/user-phone-verification', [UserController::class, 'sendVerificationOtp']);
Route::view('/otp-verifcation-form', 'user.otpVerificationForm');
Route::post('/verify-user-phone', [UserController::class, 'verifyUserPhone']);
Route::get('/watch-course/{encryptedCourseId}', [UserCourseManagement::class, 'watchCourse']);
Route::get('/update-video-status', [UserCourseManagement::class, 'updateUserVideoStatus']);
Route::get('/subscriptions', function(){
    return view('user.subscription');
});
Route::get('/payment', [PaymentController::class, 'viewPaymentPage']);


Route::prefix('guru')->group(function () {
    //Guru Email Verification

    //route after verification
    Route::get('/email/verify', function () {
        return view('auth.guru-verify-email');
    })->middleware('auth:guru')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/guru/dashboard');
    })->middleware(['auth:guru', 'signed'])->name('verification.guruVerify');
    //resend verification link
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth:guru', 'throttle:6,1'])->name('verification.guruSend');


    Route::get('/forgot-password', function () {
        return view('auth.forgot-password', ['action' => url('guru/forgot-password')]);
    })->middleware('guest')->name('guruPassword.request');

    Route::post('/forgot-password', [GuruAuth::class, 'forgotPassword'])->middleware('guest')->name('guruPassword.email');

    Route::get('/reset-password', function (Request $request) {
        return view('auth.reset-password', ['action' => url('guru/reset-password'), 'token' => $request->token, 'email' => $request->email]);
    })->middleware('guest')->name('guruPassword.reset');

    Route::post('/reset-password', [GuruAuth::class, 'resetPassword'])->middleware('guest')->name('guruPassword.reset');

    Route::get('/sign-up', function () {
        $securityQuestions = SecurityQuestion::all();
        $countries = Countries::all();
        return view('guru.guruSignup', ['securityQuestions' => $securityQuestions, 'countries' => $countries]);
    });
    Route::post('/sign-up', [GuruAuth::class, 'register']);
    Route::get('/dashboard', [GuruController::class, 'dashboard']);
    Route::get('/login', function () {
        return view('guru.guruLogin');
    })->name('guru.login');
    Route::post('/login', [GuruAuth::class, 'authenticate']);
    Route::get('/logout', [GuruAuth::class, 'logout']);
    Route::get('/view-profile', [GuruController::class, 'viewProfile']);
    Route::post('/update', [GuruController::class, 'updateGuru']);
    Route::get('/guru-settings', [GuruController::class, 'userSettings']);
    Route::post('/update-password', [GuruController::class, 'updatePassword']);

    Route::get('/guru-phone-verification', [GuruController::class, 'sendVerificationOtp']);
    Route::view('/otp-verifcation-form', 'guru.otpVerificationForm');
    Route::post('/verify-guru-phone', [GuruController::class, 'verifyUserPhone']);
});




Route::prefix('admin')->group(function () {
    Route::view('/', 'admin.login')->name('admin.login');
    Route::view('/login', 'admin.login')->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'authenticate']);
    Route::get('/logout', [AdminLoginController::class, 'logout']);

    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/user', [AdminController::class, 'users']);
    Route::get('/guru', [AdminController::class, 'gurus']);
    Route::get('/edit-user/{userId}', [AdminController::class, 'editUser']);
    Route::get('/edit-guru/{guruId}', [AdminController::class, 'editGuru']);
    Route::post('/change-user-status', [AdminController::class, 'changeUserStatus']);
    Route::post('/change-guru-status', [AdminController::class, 'changeGuruStatus']);
    Route::post('/edit-user', [AdminController::class, 'adminEditUser']);
    Route::post('/edit-guru', [AdminController::class, 'adminEditGuru']);
    Route::get('/courses', [CourseManagement::class, 'getCourses']);
    Route::get('/upload-courses', [CourseManagement::class, 'uploadCourseView']);
    Route::Post('/upload-course', [CourseManagement::class, 'uploadCourse']);
    Route::Post('/update-course', [CourseManagement::class, 'updateCourse']);
    Route::get('/edit-course/{encryptedCourseId}', [CourseManagement::class, 'editCourseView']);
    Route::get('/course/view-videos/{encryptedCourseId}', [CourseManagement::class, 'viewVideos']);
    Route::get('/video/{encryptedVideoUrl}', [CourseManagement::class, 'videoDetailsForm']);
    Route::post('/upload-videoMeta', [CourseManagement::class, 'uploadVideoMeta']);
    Route::get('/subscriptions', [AdminController::class, 'viewSubscriptions']);
    Route::get('/add-subscription', [AdminController::class, 'addSubscription']);
    Route::post('/add-subscription', [AdminController::class, 'addSubscription']);
    Route::get('/edit-subscription/{encryptedSubscriptionId}', [AdminController::class, 'editSubscription']);
    Route::post('/update-subscription', [AdminController::class, 'updateSubscription']);
    Route::get('/settings', [AdminController::class, 'settings']);
    Route::post('/set-credit-points', [AdminController::class, 'setCreditPoints']);
    Route::post('/change-course-status', [CourseManagement::class, 'changeCourseStatus']);
});