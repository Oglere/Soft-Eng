<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;


class ManageUsersController extends Controller
{
    //
    public function index()
    {
        return view('admin.manageuser'); // looks for resources/views/admin/dashboard.blade.php
    }

    public function addForm() 
    {
        return view('admin.manageuserforms.adduserform');
    }

    public function store(Request $request) 
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // always hash passwords
        ]);

        return redirect()->route('admin.manageuser.index')
        ->with('success', 'User created successfully!');
    }
}
