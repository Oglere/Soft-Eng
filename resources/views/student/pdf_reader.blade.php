@extends('layout.student')
{{-- <link rel="stylesheet" href="{{ asset('') }}"> --}}

@section('right')
    <div id="loading-overlay">
        <div class="loader"></div>
        <p>Loading...</p>
    </div>

    <div class="pdfmain" style="display: none; flex-direction: column;" id="pdf-content">
        <div class="navnav">
            <div class="leftnav">
                <div class="pdfaside">
                    <div class="nav">
                        <p>Total Pages: <span id="total-pages"></span></p>
                    </div>
                    <h2></h2>
                    <p><strong>Abstract:</strong>  </p>
                    <p><strong>Date Submitted:</strong> </p>
                    <p><strong>Study Type:</strong> {{ !empty($study_type) ? implode(', ', $study_type) : 'No keywords available.' }}</p>
                </div>
            </div>
        </div>

        <div class="pdfcontents">
            <div id="pdf-container"></div>
        </div>
    </div>

    <style>
        #loading-overlay {
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
            z-index: 9999;
        }

        .loader {
            border: 6px solid #f3f3f3;
            border-top: 6px solid #04128e;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endsection

{{-- <script src="{{ asset('') }}"></script> --}}
