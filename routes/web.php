<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController; // Login Module
use App\Http\Controllers\QueryController; // Landing Page and Search Query Module
use App\Http\Controllers\OtpController; // OTP Module

use App\Http\Controllers\Controller; // PDF Reader Module

use App\Http\Controllers\StudentController; // Student Functions
use App\Http\Controllers\TeacherController; // Teacher Functions
use App\Http\Controllers\AdminController; // Admin Functions

// Route::prefix('/layouts')->group(function (){
//     Route::get('/', [PdfController::class, 'layouts']);
//     Route::get('/plain', [PdfController::class, 'plain_layout']);
//     Route::get('/sidenav', [PdfController::class, 'sidenav_layout']);
//     Route::get('/static', [PdfController::class, 'static_pdf_layout']);
//     Route::get('/dynamic', [PdfController::class, 'dynamic_pdf_layout']);
// });

Route::prefix('/')->group(function (){
    Route::get('/', [QueryController::class, 'landing_page'])->name('landing');
    Route::get('/results/', [QueryController::class, 'results_page']);
    Route::get('/study/{id}', [QueryController::class, 'document_page']);
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

Route::middleware('auth.session:student')->prefix('student')->group(function (){
    Route::get('/dashboard', [StudentController::class, 'dashboard_page'])->name('student.dashboard'); // ✅ Add this name
    Route::get('/search', [StudentController::class, 'search_page']);
    Route::get('/submission', [StudentController::class, 'submission'])->name('student.submission');
    Route::post('/submit', [StudentController::class, 'submit_document'])->name('student.submit'); // ✅ NEW: Handles form submission
    Route::post('/student/check-title', [App\Http\Controllers\StudentController::class, 'checkTitle'])->name('student.checkTitle');
    Route::get('/doc_status/', [StudentController::class, 'doc_status_page'])->name('student.doc_status');
    Route::get('/view_status/{id}', [StudentController::class, 'viewStatus'])->name('student.view_status');
    Route::delete('/abandon/{id}', [StudentController::class, 'abandon'])->name('student.abandon');
    Route::get('/pdf-reader/{id}', [StudentController::class, 'pdf_reader_page']);
    Route::get('/account_setting', [StudentController::class, 'account_setting_page'])->name('student.account_setting');

    Route::post('/account_setting/verify', [StudentController::class, 'verify_identity'])->name('student.verify_identity');
    Route::post('/account_setting/update', [StudentController::class, 'update_account'])->name('student.update_account');
    Route::post('/account_setting/cancel', [StudentController::class, 'cancel_update'])->name('student.cancel_update');

});

Route::middleware('auth.session:teacher')->prefix('teacher')->group(function (){
    Route::get('/dashboard', [TeacherController::class, 'dashboard_page'])->name('teacher.dashboard');
    Route::get('/submitted/', [TeacherController::class, 'submitted_page'])->name('teacher.submitted.list');
    Route::get('/submitted/{id}', [TeacherController::class, 'pdf_reader_page'])->name('teacher.pdf.reader');
    Route::get('/account_setting', [TeacherController::class, 'account_setting_page'])->name('teacher.account_setting');
    Route::get('/view_submitted', [TeacherController::class, 'view_submitted_page'])->name('teacher.view_submitted');

    Route::post('/document/{id}/approve', [TeacherController::class, 'pdf_approve'])->name('teacher.document.approve');
    Route::post('/document/{id}/revise', [TeacherController::class, 'pdf_revise'])->name('teacher.document.revise');
    Route::post('/document/{id}/reject', [TeacherController::class, 'pdf_reject'])->name('teacher.document.reject');

    Route::post('/account_setting/verify', [TeacherController::class, 'verify_identity'])->name('teacher.verify_identity');
    Route::post('/account_setting/update', [TeacherController::class, 'update_account'])->name('teacher.update_account');
    Route::post('/account_setting/cancel', [TeacherController::class, 'cancel_update'])->name('teacher.cancel_update');

});


Route::middleware('auth.session:admin')->prefix('admin')->group(function (){
    Route::get('/dashboard', [AdminController::class, 'dashboard_page'])->name('admin.dashboard');
    Route::get('/manage-users/', [AdminController::class, 'user_control_page'])->name('manage.user');
    Route::get('/manage-users/recover', [AdminController::class, 'user_recovery_page'])->name('recover.user');
    Route::get('/storage/', [AdminController::class, 'storage_page'])->name('storage');
    Route::get('/storage/{id}', [AdminController::class, 'storage_page'])->name('admin.pdf.reader');
    Route::get('/account_setting/', [AdminController::class, 'account_setting_page'])->name('admin.account_setting');

    Route::post('/account_setting/verify', [AdminController::class, 'verify_identity'])->name('admin.verify_identity');
    Route::post('/account_setting/update', [AdminController::class, 'update_account'])->name('admin.update_account');
    Route::post('/account_setting/cancel', [AdminController::class, 'cancel_update'])->name('admin.cancel_update');
});
