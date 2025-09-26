<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TeacherController extends Controller
{
    public function dashboard_page() {
        return view('teacher.dashboard');
    }

    public function review_page() {
        return view('teacher.review');

    }

    public function pdf_reader_page() {
        return view('teacher.pdf_reader');

    }

    public function account_setting_page() {
        return view('teacher.accountsetting');

    }
}
