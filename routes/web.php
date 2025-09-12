<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController; // Login Module
use App\Http\Controllers\QueryController; // Landing Page and Search Query Module
use App\Http\Controllers\OtpController; // OTP Module

use App\Http\Controllers\Controller; // PDF Reader Module

use App\Http\Controllers\StudentController; // Student Functions

use App\Http\Controllers\TeacherController; // Teacher Functions

use App\Http\Controllers\AdminController; // Admin Functions

// Experminetal
Route::get('/', function () {
    return view('welcome');
});

Route::get('/layouts/plain', function () {
    return view('layout.plain');
});

Route::get('/layouts/sidenav', function () {
    return view('layout.sidenavbar');
});

// Route::prefix('/')->group(function (){
//     Route::get('/', [QueryController::class, 'landing_page']);
//     Route::get('/results/', [QueryController::class, 'results_page']);
//     Route::get('/document/{id}', [QueryController::class, 'document_page']);
//     Route::get('/go/login', [QueryController::class, 'login_page']);
//     Route::get('/go/recovery', [QueryController::class, 'recovery_page']);
//     Route::get('/go/recovery/verify', [QueryController::class, 'otp_page']);

//     Route::post('/send', [QueryController::class, 'send'])->name('send');
//     Route::post('/insert-user', [QueryController::class, 'insertUser'])->name('insert.user');
// });

// Route::prefix('student')->group(function (){
//     Route::get('/', [StudentController::class, 'dashboard_page']);
//     Route::get('/submission/', [StudentController::class, 'submission_page']);
//     Route::get('/doc-status/', [StudentController::class, 'doc_status_page']);
//     Route::get('/pdf-reader/{id}', [StudentController::class, 'pdf_reader_page']);
//     Route::get('/account-setting/', [StudentController::class, 'account_setting_page']);

//     // Route::post(); // Back End

// });

// Route::prefix('teacher')->group(function (){
//     Route::get('/', [TeacherController::class, 'dashboard_page']);
//     Route::get('/review-document/', [TeacherController::class, 'review_page']);
//     Route::get('/review-document/{id}', [TeacherController::class, 'pdf_reader_page']);
//     Route::get('/account-setting/', [TeacherController::class, 'account_setting_page']);

//     // Route::post(); // Back End

// });

// Route::prefix('admin')->group(function (){
//     Route::get('/', [AdminController::class, 'dashboard_page']);
//     Route::get('/manage-users/', [AdminController::class, 'user_control_page']);
//     Route::get('/storage/', [AdminController::class, 'storage_page']);
//     Route::get('/account-setting/', [AdminController::class, 'account_setting_page']);

//     // Route::post(); // Back End

// });

// Route::prefix('environment')->group(function (){
//     Route::get('/', [Controller::class, 'pdf_reader']);


// });

