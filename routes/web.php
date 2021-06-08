<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminController;

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
Route::get('/sign-up', function () {
    return view('signup');
});
Route::get('/login', function () {
    return view('login');
});
Route::get('/dashboard', function () {
    return view('user.dashboard');
});


Route::view('/admin', 'admin.login')->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'authenticate']);
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('/admin/user', [AdminController::class, 'users']);
Route::get('/admin/edit-user/{userId}', [AdminController::class, 'editUser']);
Route::post('/admin/change-user-status', [AdminController::class, 'changeUserStatus']);

