@extends('layout.student')
<link rel="stylesheet" href="{{ asset('css/student/submit.css') }}">

@section('right')
<div class="frbg">
    <div class="notif">
        <div class="imghere">
            <img src="../../imgs/review.png" alt="" />
        </div>
        <div class="teksto" style="display: flex; margin-top: -16px; text-align: center"></div>
    </div>
</div>

<h1 style="font-weight: bolder;color: black;">SUBMIT A DOCUMENT</h1>
@if(session('success'))
    <div style="color: green; text-align: center; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

<form id="documentForm" method="post" enctype="multipart/form-data" 
      action="{{ route('student.submit') }}"
      style="background-color: #f5f5f5; padding: 40px; border-radius: 10px; box-shadow: 5px 5px 1px #04128e;">
    @csrf

    <div id="globalError" class="error" style="display:none; font-weight:bold; text-align:center; margin-bottom:15px;">
        Please fill out all required fields before submitting.
    </div>

    <div class="form-row">
        <!-- LEFT COLUMN -->
        <div class="form-col left-col">
            <div class="container">
                <div class="card"> 
                    <h3>Upload File</h3> 
                    <div class="drop_box">
                        <div class="header"><h4>Select File here</h4></div>
                        <p>Files Supported: PDF (max 25MB)</p>
                        <input type="file" name="file" accept=".pdf" id="fileID" style="display:none;">
                        <button type="button" class="btn" id="chooseFileBtn">Choose File</button>
                        <p id="fileNameDisplay" style="color: red;"></p>
                        <div id="fileError" class="error" style="margin-bottom: 0"></div>
                    </div>
                </div>
            </div>

            <label for="keywords">Type of Studies:</label><div id="typeError" class="error"></div>
            <div class="checkboxes">
                <div class="chkbx"><input type="checkbox" name="document_types[]" value="Case Study"><label>Case Study</label></div>
                <div class="chkbx"><input type="checkbox" name="document_types[]" value="Thesis"><label>Thesis</label></div>
                <div class="chkbx"><input type="checkbox" name="document_types[]" value="Proposal"><label>Proposal</label></div>
                <div class="chkbx"><input type="checkbox" name="document_types[]" value="Capstone"><label>Capstone</label></div>
                <div class="chkbx"><input type="checkbox" name="document_types[]" value="System Studies"><label>System Studies</label></div>
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="form-col right-col">
            <label for="title">Title:</label>
            <input id="title" type="text" name="title">
            <div id="titleError" class="error"></div>

            <label for="abstract">Abstract:</label>
            <textarea id="abstract" name="abstract"></textarea>
            <div id="abstractError" class="error"></div>

            <label for="keywords">Keywords:</label>
            <input id="keywords" type="text" name="keywords">
            <div id="keywordsError" class="error"></div>

            <label for="teacher_id">Teacher:</label>
            <select id="teacher_id" name="teacher_id">
                <option value="">-- Select Teacher --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->user_id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                @endforeach
            </select>
            <div id="teacherError" class="error"></div>

            <label for="publication_date">Submission Date:</label>
            <input id="publication_date" type="date" name="publication_date">
            <div id="dateError" class="error"></div>

            <label for="citations">Citations (comma-separated):</label>
            <input id="citations" type="text" name="citations">
            <div id="citationsError" class="error"></div>
        </div>
    </div>

    <button class="submission" type="submit" id="submitButton"
            style="background-color: #04128e; border-radius: 10px; border: none; padding: 15px;">
        Submit
    </button>
</form>

<div id="alrt" style="color: black; margin-top: 10px; text-align: center;"></div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#04128e',
    });
});
</script>
@endif

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("documentForm");
    const fileInput = document.getElementById("fileID");
    const chooseFileBtn = document.getElementById("chooseFileBtn");
    const fileNameDisplay = document.getElementById("fileNameDisplay");
    const checkboxes = document.querySelectorAll(".chkbx input[type='checkbox']");
    const dateField = document.getElementById('publication_date');

    // ✅ Set min date to today
    const today = new Date().toISOString().split('T')[0];
    dateField.setAttribute('min', today);

    // ✅ Checkbox UI toggle
    document.querySelectorAll(".chkbx").forEach(wrapper => {
        const checkbox = wrapper.querySelector('input');
        wrapper.addEventListener("click", () => {
            checkbox.checked = !checkbox.checked;
            wrapper.classList.toggle("active", checkbox.checked);
        });
    });

    // ✅ File selection
    chooseFileBtn.addEventListener("click", () => fileInput.click());
    fileInput.addEventListener("change", () => {
        const file = fileInput.files[0];
        if (file) {
            if (file.type !== "application/pdf") {
                fileNameDisplay.textContent = "Only PDF files are allowed.";
                fileNameDisplay.style.color = "red";
                fileInput.value = "";
            } else if (file.size > 25 * 1024 * 1024) { // 25MB
                fileNameDisplay.textContent = "File exceeds 25MB limit.";
                fileNameDisplay.style.color = "red";
                fileInput.value = "";
            } else {
                fileNameDisplay.textContent = file.name;
                fileNameDisplay.style.color = "green";
            }
        }
    });

    // ✅ Frontend validation before submit
    form.addEventListener("submit", function (e) {
        let valid = true;

        // Clear previous errors
        document.querySelectorAll(".error").forEach(el => el.textContent = "");

        const title = document.getElementById("title");
        const abstract = document.getElementById("abstract");
        const keywords = document.getElementById("keywords");
        const teacher = document.getElementById("teacher_id");
        const citations = document.getElementById("citations");
        const file = fileInput.files[0];
        const checkedTypes = Array.from(checkboxes).some(c => c.checked);

        // Validate each field
        if (!title.value.trim()) { document.getElementById("titleError").textContent = "Title is required."; valid = false; }
        if (!abstract.value.trim()) { document.getElementById("abstractError").textContent = "Abstract is required."; valid = false; }
        if (!keywords.value.trim()) { document.getElementById("keywordsError").textContent = "Keywords are required."; valid = false; }
        if (!teacher.value) { document.getElementById("teacherError").textContent = "Please select a teacher."; valid = false; }
        if (!checkedTypes) { document.getElementById("typeError").textContent = "Select at least one type of study."; valid = false; }
        if (!file) { document.getElementById("fileError").textContent = "Please upload a PDF file."; valid = false; }
        if (!citations.value.trim()) { document.getElementById("citationsError").textContent = "Citations are required."; valid = false; }

        if (file && (file.type !== "application/pdf" || file.size > 25 * 1024 * 1024)) {
            document.getElementById("fileError").textContent = "Invalid file. Must be PDF and ≤ 25MB.";
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
            document.getElementById("globalError").style.display = "block";
            window.scrollTo({ top: 0, behavior: "smooth" });
        }
    });
});
</script>
