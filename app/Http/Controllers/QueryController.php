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

    public function results_page(Request $request)
    {
        $user = auth()->user();

        // Start query
        $query = \App\Models\DocumentRepository::query();

        // 🔍 Search keyword
        if ($request->filled('search')) {
            $keyword = $request->input('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('metadata', 'like', "%{$keyword}%")
                ->orWhere('study_type', 'like', "%{$keyword}%");
            });
        }

        // 📅 Date range
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('date_submitted', [
                $request->input('date_from'),
                $request->input('date_to'),
            ]);
        }

        // 📂 Document types
        if ($request->filled('document_types')) {
            $types = $request->input('document_types');
            $query->whereIn('study_type', $types);
        }

        // ✅ Final results
        $results = $query->orderBy('date_submitted', 'desc')->get();

        return view('guest.results', [
            'role' => $user ? $user->role : 'guest',
            'results' => $results,
        ]);
    }


    public function login_page() {
        return view('guest.login');
    }


}
