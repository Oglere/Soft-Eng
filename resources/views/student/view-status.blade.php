@extends('layout.student')
<link rel="stylesheet" href="{{ asset('') }}">
<style>
    body {
    background-color: #fdf9e9;
    }
    .main {
        display: flex;
        overflow: hidden;
    }
    header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 30px !important;
        background-color: #fdf9e9;
        border-bottom: 3px solid #000 !important;
    }
    header h2 {
        letter-spacing: 5px;
		margin-left: 35px;
        padding: 0;
        font-weight: bold;
        color: #04128e;
        text-align: left;
    }
    .home-icon,
    .feather-log-in {
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .home-icon:hover,
    .feather-log-in:hover {
        transform: scale(1.2);
    }
    .ahh {
        display: flex;
        align-items: center;
    }
    .left {
        border-right: 3px solid #000 !important;
    }
    .profile {
        margin: 10px !important;
    }
    .profile h2 {
        font-weight: bold; 
        font-size: 30px; 
        color: #000;
        letter-spacing: 2px;
    }
</style>

@section('right')

  <div style="display:flex; justify-content:space-between; align-items:flex-start; width:100%; padding: 0px 40px;">

    <!-- Left side: document details -->
    <div>
        <p><strong>Total Pages:</strong> {{ $document->total_pages ?? 'N/A' }}</p>
        <p><strong>Title:</strong> {{ $document->title }}</p>
        <p><strong>Abstract:</strong> {{ $document->abstract ?? 'N/A' }}</p>
        <p><strong>Date Submitted:</strong> {{ $document->date_submitted ? $document->date_submitted->format('F d, Y') : 'N/A' }}</p>
        <p><strong>Study Type:</strong> {{ is_array($document->document_types) ? implode(', ', $document->document_types) : 'N/A' }}</p>
    </div>

        <!-- Right side: Abandon Button -->
        <form method="POST" action="{{ route('student.abandon', ['id' => $document->document_id]) }}">
            @csrf
            @method('DELETE')
            <button type="submit" style="background-color:#ff4d4d; color:white; border:none; padding:10px 20px; border-radius:8px; display:flex; align-items:center; gap:5px; cursor:pointer; margin-bottom: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                    <path d="M10 11v6"></path>
                    <path d="M14 11v6"></path>
                </svg>
                Abandon Document
            </button>
            <a href="{{ url('student/doc-status')}}"
            style="background-color:#afafaf;color:white;border:none;padding:10px 20px;border-radius:8px;display:flex;align-items:center;gap:5px;cursor:pointer;text-decoration:none;font-size: 13px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                    <path d="M10 11v6"></path>
                    <path d="M14 11v6"></path>
                </svg>
                Go Back
            </a>
        </form>
    </div>
</div>
@endsection

<script src="{{ asset('') }}"></script>
