@extends('layout.student')
<link rel="stylesheet" href="{{ asset('css/student/submit.css') }}">
<style>
    .submission{
        background-color: #ff4d4d;
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        
    }
    
    header h2 {
        letter-spacing: 5px;
		margin-left: 35px;
        padding: 0;
        font-weight: bold;
        color: #04128e;
        text-align: left;
    }

    .ahh {
        display: flex;
        align-items: center;
    }
    .error {
        color: red;
        font-size: 0.9em;
        margin-bottom: 10px;
    }
    .chkbx {
        display: flex;
        justify-content: center;
        border: 3px solid #04128e !important;
    }
    .checkboxes input[type="checkbox"]:checked {
        background-color: red;
        border-color: red;
        accent-color: red;
    }
    .chkbx:has(input[type="checkbox"]:checked) {
        background-color: #04128e;
    }
    .chkbx:has(input[type="checkbox"]:checked) label {
        color: white;
    }
    .checkboxes input[type="checkbox"]:checked::before {
        color: white;
    }
    .container .card{
        height: 330px;
        width: 100%;
    }
    .submission {
        font-weight: bold;
        letter-spacing: 1px;
    }
    .submission:hover {
        cursor: pointer;
        background-color: #071bcc !important; 
    }
</style>

@section('right')
    <div class="frbg">
        <div class="notif">
            <div class="imghere">
                <img src="../../imgs/review.png" alt="" />
            </div>
            <div
                class="teksto"
                style="display: flex; margin-top: -16px; text-align: center"
            >
                <p>
                Submitted <br />
                Succesfully!
                </p>
            </div>
        </div>
    </div>

    <h1 style="font-weight: bolder;color: black;">SUBMIT A DOCUMENT</h1>
    @if(session('success'))
        <div style="color: green; text-align: center; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif
    <form style="background-color: #f5f5f5; padding: 40px; border-radius: 10px; box-shadow: 5px 5px 1px #04128e;" 
        id="documentForm" method="post" enctype="multipart/form-data" action="{{ route('student.submit') }}">
        @csrf
        
        <!-- 🔴 Global Error Message -->
        <div id="globalError" class="error" style="display:none; font-weight:bold; text-align:center; margin-bottom:15px;">
            You need to fill the whole form before submitting.
        </div>

        <label for="title">Title:</label>
        <input id="title" type="text" name="title" style="font-weight: bold; border: 1px solid black;">
        <div id="titleError" class="error"></div>

        <label for="abstract">Abstract:</label>
        <textarea id="abstract" name="abstract" style="font-weight: bold; border: 1px solid black;"></textarea>
        <div id="abstractError" class="error"></div>

        <label for="keywords">Keywords:</label>
        <input id="keywords" type="text" name="keywords" style="font-weight: bold; border: 1px solid black;">
        <div id="keywordsError" class="error"></div>

        <label for="teacher_id">Teacher:</label>
        <select id="teacher_id" name="teacher_id" style="font-weight: bold; border: 1px solid black;">
            <option value="">-- Select Teacher --</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->user_id }}">
                    {{ $teacher->first_name }} {{ $teacher->last_name }}
                </option>
            @endforeach
        </select>
        <div id="teacherError" class="error"></div>

        <label for="publication_date">Submission Date:</label>
        <input id="publication_date" type="date" name="publication_date" style="font-weight: bold; border: 1px solid black;">
        <div id="dateError" class="error"></div>

        <label for="citations">Citations (comma-separated):</label>
        <input id="citations" type="text" name="citations" style="font-weight: bold; border: 1px solid black;">
        <div id="citationsError" class="error"></div><br>

        <!-- File upload -->
        <div class="container" style="background-color: #f5f5f5;">
            <div class="card"> 
                <h3>Upload File</h3> 
                <div class="drop_box">
                    <div class="header"><h4>Select File here</h4></div>
                    <p>Files Supported: PDF</p>
                    <input type="file" name="file" accept=".pdf" id="fileID" style="display:none;">
                    <button style="background-color: black;" type="button" class="btn" id="chooseFileBtn">Choose File</button>
                    <p id="fileNameDisplay" style="color: red;"></p>
                    <div id="fileError" class="error"></div>
                </div>
            </div>
        </div>

        <!-- Checkboxes -->
        <div class="checkboxes">
            <div class="chkbx"><input type="checkbox" name="document_types[]" value="Case Study"><label>Case Study</label></div>
            <div class="chkbx"><input type="checkbox" name="document_types[]" value="Thesis"><label>Thesis</label></div>
            <div class="chkbx"><input type="checkbox" name="document_types[]" value="Proposal"><label>Proposal</label></div>
            <div class="chkbx"><input type="checkbox" name="document_types[]" value="Capstone"><label>Capstone</label></div>
            <div class="chkbx"><input type="checkbox" name="document_types[]" value="System Studies"><label>System Studies</label></div>
        </div>
        <div id="typeError" class="error"></div>

        <!-- ✅ Only ONE submit button -->
        <button style="background-color: #04128e; border-radius: 10px; border: none; padding: 15px;" 
                        class="submission" type="submit" id="submitButton">Submit</button>
            </form>
        <button style="background-color: #04128e" class="submission" type="submit" id="submitButton" disabled>Submit</button>
    <div id="alrt" style="color: black; margin-top: 10px; text-align: center;"></div>
</form>  
@endsection

<script src="{{ asset('') }}"></script>
