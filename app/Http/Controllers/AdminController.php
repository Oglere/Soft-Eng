<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard_page() {
        return view('admin.Dashboard');
    }

    public function user_control_page() {
        return view('admin.ManageUser');
    }

    public function account_recovery() {
    }

    public function storage_page() {
        return view('admin.Storage');
    }

    public function account_setting_page() {
        return view('admin.EditAcc');
    }

}
