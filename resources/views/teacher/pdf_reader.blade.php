@extends('layout.teacher')
{{-- <link rel="stylesheet" href="{{ asset('') }}"> --}}
<style>
    .pdfview {
        height: 100%;
    }

    .forms {
        position: absolute;
        top: 50px;
        right: 20px;
        z-index: 10;
        display: flex;
        gap: 10px;
    }

    .btn123 {
        border: none;
        border-radius: 6px;
        padding: 8px;
        cursor: pointer;
        color: white;
        transition: 0.2s;
    }

    .btn123:hover { transform: scale(1.1); }

    .btn123.green { background-color: #198754; }
    .btn123.blue { background-color: #030281; }
    .btn123.red { background-color: #dc3545; }

    /* Modal Overlay */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.6);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 999;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    .modal-overlay.active {
        display: flex;
        opacity: 1;
    }

    .modal-box {
        background: white;
        padding: 20px;
        border-radius: 10px;
        width: 320px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        animation: pop 0.2s ease;
    }

    @keyframes pop {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .modal-buttons {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    button.confirm {
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        color: white;
        font-weight: bold;
        cursor: pointer;
    }

    button.confirm.green { background-color: #198754; }
    button.confirm.blue { background-color: #030281; }
    button.confirm.red { background-color: #dc3545; }

    button.cancel {
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        background-color: #6c757d;
        color: white;
        font-weight: bold;
        cursor: pointer;
    }

    .popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        animation: fadeIn 0.3s ease;
    }

    .popup-box {
        background: #fff;
        padding: 25px 40px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        animation: slideUp 0.3s ease;
    }

    .popup-box h3 {
        color: #04128e;
        margin-bottom: 10px;
    }

    .popup-box p {
        margin-bottom: 15px;
    }

    .popup-box button {
        background-color: #04128e;
        color: white;
        border: none;
        padding: 8px 18px;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
    }

    @keyframes fadeIn {
        from { opacity: 0; } to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>

@section('right')
<div class="pdf-container" style="position: relative; width: 100%; height: 100%;">
    @if ($document->status != "Approved")
        <div class="forms">
            <button class="btn123 green" onclick="openModal('approveModal')">
                <svg style="margin: 0;" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-check-circle">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </button>

            <button class="btn123 blue" onclick="openModal('revisionModal')">
                <svg style="margin: 0;" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-repeat">
                    <polyline points="17 1 21 5 17 9"/>
                    <path d="M3 11V9a4 4 0 0 1 4-4h14"/>
                    <polyline points="7 23 3 19 7 15"/>
                    <path d="M21 13v2a4 4 0 0 1-4 4H3"/>
                </svg>
            </button>

            <button class="btn123 red" onclick="openModal('rejectModal')">
                <svg style="margin: 0;" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-x">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <div id="approveModal" class="modal-overlay">
            <div class="modal-box">
                <h3>Confirm Approval</h3>
                <p>Are you sure you want to <strong>approve</strong> this document?</p>
                <div class="modal-buttons">
                    <form method="POST" action="{{ route('teacher.approve', $document->document_id) }}">
                        @csrf
                        <button type="submit" class="confirm green">Confirm</button>
                        <button type="button" class="cancel" onclick="closeModal('approveModal')">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="revisionModal" class="modal-overlay">
            <div class="modal-box">
                <h3>Send for Revision</h3>
                <p>Are you sure you want to mark this document as <strong>needs revision</strong>?</p>
                <div class="modal-buttons">
                    <form method="POST" action="{{ route('teacher.revise', $document->document_id) }}">
                        @csrf
                        <button type="submit" class="confirm blue">Confirm</button>
                        <button type="button" class="cancel" onclick="closeModal('revisionModal')">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="rejectModal" class="modal-overlay">
            <div class="modal-box">
                <h3>Reject Document</h3>
                <p>Are you sure you want to <strong>reject</strong> this document?</p>
                <div class="modal-buttons">
                    <form method="POST" action="{{ route('teacher.reject', $document->document_id) }}">
                        @csrf
                        <button type="submit" class="confirm red">Confirm</button>
                        <button type="button" class="cancel" onclick="closeModal('rejectModal')">Cancel</button>
                    </form>
                </div>
            </div>
        </div>

    @elseif ($document->status === "Approved")
        <div class="forms">
            <button class="btn123 green" onclick="openModal('revertModal')">
                <svg style="margin: 0;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-corner-up-left"><polyline points="9 14 4 9 9 4"/><path d="M20 20v-7a4 4 0 0 0-4-4H4"/></svg>
            </button>
        </div>

        <div id="revertModal" class="modal-overlay">
            <div class="modal-box">
                <h3>Revert Document</h3>
                <p>Are you sure you want to <strong>revert</strong> this document?</p>
                <div class="modal-buttons">
                    <form method="POST" action="{{ route('teacher.revert', $document->document_id) }}">
                        @csrf
                        <button type="submit" class="confirm red">Confirm</button>
                        <button type="button" class="cancel" onclick="closeModal('revertModal')">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <div class="pdfview" style="width: 100%; height: 100%;">
        @if($document->file && file_exists(public_path('storage/' . $document->file)))
            <embed src="{{ asset('storage/' . $document->file) }}"
                   type="application/pdf"
                   width="100%" height="100%"
                   style="border-radius: 10px;">
        @elseif($document->file && file_exists(public_path($document->file)))
            <embed src="{{ asset($document->file) }}"
                   type="application/pdf"
                   width="100%" height="100%"
                   style="border-radius: 10px;">
        @else
            <div class="no-file">
                <p>No PDF file found for this document.</p>
            </div>
        @endif
    </div>

    @if(session('success'))
        <div id="popup" class="popup">
            <div class="popup-box">
                <h3>Done</h3>
                <p>{{ session('success') }}</p>
                <button onclick="closePopup()">OK</button>
            </div>
        </div>
    @endif

</div>
@endsection

<script>
function openModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('active');
}

function closeModal(id) {
    const modal = document.getElementById(id);
    modal.classList.remove('active');
}

window.addEventListener('click', function(e) {
    document.querySelectorAll('.modal-overlay.active').forEach(modal => {
        if (e.target === modal) modal.classList.remove('active');
    });
});
</script>

<script>
    function closePopup() {
        document.getElementById('popup').style.display = 'none';
    }

    // Optional: auto-close popup after 2.5s
    window.addEventListener('DOMContentLoaded', function() {
        const popup = document.getElementById('popup');
        if (popup) {
            setTimeout(() => {
                popup.style.display = 'none';
            }, 2500);
        }
    });
</script>
