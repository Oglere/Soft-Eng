<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    public function dashboard_page() {
        return view ('admin.dashboard');
    }

    public function user_control_page() {
        return view ('admin.manage_users');
    }

    public function user_recovery_page() {
        return view ('admin.recovery');
    }

    public function storage_page() {
        return view ('admin.storage');
    }

    public function account_setting_page() {
        return view ('admin.accountsetting');
    }


}
