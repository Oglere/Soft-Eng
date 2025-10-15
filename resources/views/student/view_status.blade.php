@extends('layout.student')
<link rel="stylesheet" href="{{ asset('css/student/view_status.css') }}">

@section('right')

    <div class="viewContainer">
        <!-- Left side: document details -->
        <div class="par">
            <p><strong>Title:</strong> {{ $document->title }}</p>
            <p><strong>Abstract:</strong> 
                {{ $document->abstract ?? ($document->metadata['abstract'] ?? 'N/A') }}
            </p>
            <p><strong>Date Submitted:</strong> 
                {{ $document->date_submitted ? $document->date_submitted->format('F d, Y') : 'N/A' }}
            </p>
            <p><strong>Study Type:</strong> 
                {{ is_array($document->document_types) ? implode(', ', $document->document_types) : 'N/A' }}
            </p>
        </div>

        <!-- Right side: Abandon Button -->
        <form id="abandonForm" method="POST" 
              action="{{ route('student.abandon', ['id' => $document->document_id]) }}">
            @csrf
            @method('DELETE')
            
            <button type="button" id="abandonBtn" class="par-btn" style="background-color:#ff4d4d;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" 
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                    <path d="M10 11v6"></path>
                    <path d="M14 11v6"></path>
                </svg>
                Abandon Document
            </button>

            <a href="{{ route('student.doc_status') }}" class="par-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" 
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                    <path d="M10 11v6"></path>
                    <path d="M14 11v6"></path>
                </svg>
                Go Back
            </a>
        </form>
    </div>

    {{-- ✅ Dynamic PDF viewer --}}
    <div class="pdfview">
        @if($document->file && file_exists(public_path('storage/' . $document->file)))
            <embed src="{{ asset('storage/' . $document->file) }}"
                type="application/pdf"
                width="100%" height="100%"
                style="border-radius: 20px;">
        @elseif($document->file && file_exists(public_path($document->file)))
            {{-- For manually stored files under /public/uploads/... --}}
            <embed src="{{ asset($document->file) }}"
                type="application/pdf"
                width="100%" height="100%"
                style="border-radius: 20px;">
        @else
            <div class="no-file">
                <p>No PDF file found for this document.</p>
            </div>
        @endif
    </div>
@endsection

{{-- ✅ SweetAlert Confirm Dialog --}}
<script src="{{asset('js/student/sweetalert2@11.js')}}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const abandonBtn = document.getElementById('abandonBtn');
    const abandonForm = document.getElementById('abandonForm');

    abandonBtn.addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Abandon Document?',
            text: "Are you sure you want to abandon this document? You can’t undo this action unless you resubmit it.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, abandon it',
            cancelButtonText: 'Revert'
        }).then((result) => {
            if (result.isConfirmed) {
                abandonForm.submit();
            } else {
                Swal.fire({
                    title: 'Cancelled',
                    text: 'Your document is safe and was not abandoned.',
                    icon: 'info',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });
});
</script>
