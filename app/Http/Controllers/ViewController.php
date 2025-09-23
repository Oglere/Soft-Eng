<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    //

    public function Dashboard() {
        return view('layout.Dashboard');
    }
    public function EditAcc() {
        return view('layout.EditAcc');
    }
    public function ManageUser() {
        return view('layout.ManageUser');
    }
    public function Storage() {
        return view('layout.Storage');
    }
}
