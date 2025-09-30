<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    //
    public function index()
    {
        return view('admin.storage'); // looks for resources/views/admin/dashboard.blade.php
    }
}
