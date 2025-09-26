<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController; // Login Module
use App\Http\Controllers\QueryController; // Landing Page and Search Query Module
use App\Http\Controllers\OtpController; // OTP Module

use App\Http\Controllers\PdfController; // PDF Reader Module

use App\Http\Controllers\StudentController; // Student Functions

use App\Http\Controllers\TeacherController; // Teacher Functions

use App\Http\Controllers\AdminController; // Admin Functions

Route::prefix('/layouts')->group(function (){
    Route::get('/', [PdfController::class, 'layouts']);
    Route::get('/plain', [PdfController::class, 'plain_layout']);
    Route::get('/sidenav', [PdfController::class, 'sidenav_layout']);
    Route::get('/static', [PdfController::class, 'static_pdf_layout']);
    Route::get('/dynamic', [PdfController::class, 'dynamic_pdf_layout']);
});

Route::prefix('/')->group(function (){
    Route::get('/', [QueryController::class, 'landing_page'])->name('landing');
    Route::get('/results/', [QueryController::class, 'results_page']);
    Route::get('/document/{id}', [QueryController::class, 'document_page']);
    Route::get('/auth/login', [LoginController::class, 'login_page'])->name('login.page');
    Route::get('/auth/recovery', [OtpController::class, 'recovery_page'])->name('password.recover');
    Route::get('/auth/verify-otp', [OtpController::class, 'showVerifyOtpForm'])->name('password.verify.form');
    Route::get('/auth/reset-password', [OtpController::class, 'showResetForm'])->name('password.reset.form');

    Route::post('/auth/login', [LoginController::class, 'authenticate'])->name('login');
    Route::post('/auth/recovery', [OtpController::class, 'sendRecovery'])->name('password.recover.send');
    Route::post('/auth/verify-otp', [OtpController::class, 'verifyOtp'])->name('password.verify');
    Route::post('/auth/reset-password', [OtpController::class, 'resetPassword'])->name('password.reset');
    Route::post('/auth/resend-otp', [OtpController::class, 'resendOtp'])->name('password.otp.resend');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});

Route::prefix('student')->group(function (){
    Route::get('/', [StudentController::class, 'dashboard_page'])->name('student.dashboard');
    Route::get('/submission/', [StudentController::class, 'submission_page'])->name('document.submission');
    Route::get('/doc-status/', [StudentController::class, 'doc_status_page'])->name('document.status');
    Route::get('/pdf-reader/{id}', [StudentController::class, 'pdf_reader_page'])->name('student.pdf.reader');
    Route::get('/account-setting/', [StudentController::class, 'account_setting_page'])->name('student.account.setting');

});

Route::prefix('teacher')->group(function (){
    Route::get('/', [TeacherController::class, 'dashboard_page'])->name('teacher.dashboard');
    Route::get('/review-document/', [TeacherController::class, 'review_page'])->name('teacher.review');
    Route::get('/review-document/{id}', [TeacherController::class, 'pdf_reader_page'])->name('teacher.pdf.reader');
    Route::get('/account-setting/', [TeacherController::class, 'account_setting_page'])->name('teacher.account.setting');

});

Route::prefix('admin')->group(function (){
    Route::get('/', [AdminController::class, 'dashboard_page'])->name('admin.dashboard');
    Route::get('/manage-users/', [AdminController::class, 'user_control_page'])->name('manage.user');
    Route::get('/manage-users/recover', [AdminController::class, 'user_recovery_page'])->name('recover.user');
    Route::get('/storage/', [AdminController::class, 'storage_page'])->name('storage');
    Route::get('/storage/{id}', [AdminController::class, 'storage_page'])->name('admin.pdf.reader');
    Route::get('/account-setting/', [AdminController::class, 'account_setting_page'])->name('admin.account.setting');

});
