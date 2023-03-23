<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentReqController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');   
});

//routes for manage students by Admin user only, the student can show his data

Route::resource('/student', StudentController::class)->middleware('isAdmin');
Route::get('/studentShow/{id}', [StudentController::class, 'show'])->name('student1.show')->middleware('auth');


//routes for students request, the student cannot show all of 
Route::resource('/studentReq', StudentReqController::class)->middleware('auth');
Route::get('/studentReq', [StudentReqController::class, 'index'])->name('studentReq.index')->middleware('isAdmin');

Route::get('/main', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/users',UserController::class)->middleware('isAdmin');