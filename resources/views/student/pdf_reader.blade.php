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
@endsection

<script src="{{asset('js/student/sweetalert2@11.js')}}"></script>
