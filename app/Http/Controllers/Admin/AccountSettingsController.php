<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountSettingsController extends Controller
{
    //
    public function index()
    {
        return view('admin.dashboard'); // looks for resources/views/admin/dashboard.blade.php
    }


        public function editaccView()
    {
        return view('admin.editacc');
    }

    // mao ako gibutang ari kay under raman gihapon sa accountsettings diba ang pag edit?
    //crud lang update account.  recover tas edit acc. bali mo recover sa siya para maka access siya sa pag edit sa iyang acc. naay kuan session gani. like mo changepass kas acc nimo
    // need nimno email acc okioki

}
