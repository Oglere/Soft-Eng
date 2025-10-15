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

        // 🔍 Keyword search
        if ($request->filled('search')) {
            $keyword = $request->input('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('metadata', 'like', "%{$keyword}%")
                ->orWhere('study_type', 'like', "%{$keyword}%");
            });
        }

        // 📅 Date range filter
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('date_submitted', [
                $request->input('date_from'),
                $request->input('date_to'),
            ]);
        }

        // 📂 Study type filter (supports multi-values like "Thesis, System Study")
        if ($request->filled('document_types')) {
            $types = $request->input('document_types');
            $query->where(function ($q) use ($types) {
                foreach ($types as $type) {
                    $q->orWhere('study_type', 'like', "%{$type}%");
                }
            });
        }

        // ✅ Fetch results
        $results = $query->orderBy('date_submitted', 'desc')->get();

        return view('guest.results', [
            'role' => $user ? $user->role : 'guest',
            'results' => $results,
        ]);
    }

    public function document_page($id)
    {
        $user = auth()->user();

        // Fetch only approved documents
        $document = \App\Models\DocumentRepository::findOrFail($id)
            ->where('status', 'Approved')
            ->firstOrFail();

        return view('guest.pdf_reader', [
            'document' => $document,
            'role' => $user ? $user->role : 'guest',
        ]);
    }


    public function login_page() {
        return view('guest.login');
    }


}
