<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StudentController extends Controller
{
    public function dashboard_page() {
        return view('student.dashboard');
    }

    public function submission_page() {
        return view('student.submission');

    }

    public function doc_status_page() {
        return view('student.doc_status');

    }

    public function pdf_reader_page() {
        return view('student.pdf_reader');

    }

    public function account_setting_page() {
        return view('student.accountsetting');

    }
}
