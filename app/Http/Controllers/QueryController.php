<?php

namespace App\Http\Controllers;
use App\Models\DocumentRepository;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class QueryController extends Controller
{
    public function landing_page()
    {
        $user = auth()->user(); // Get the authenticated user object

        return view('index', [
            'role' => $user ? $user->role : 'guest', // Send a string, not an object
        ]);
    }


    public function login_page() {
        return view('guest.login');
    }


}
