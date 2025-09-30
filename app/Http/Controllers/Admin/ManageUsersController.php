<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageUsersController extends Controller
{
    //
    public function index()
    {
        return view('admin.manageuser'); // looks for resources/views/admin/dashboard.blade.php
    }
}
