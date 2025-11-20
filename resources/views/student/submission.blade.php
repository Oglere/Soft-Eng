<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>D.A.R.A - Submit a Document</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
  <link rel="stylesheet" href="{{ asset('css/student/submit.css') }}">
</head>
<body>
    <div class="navbar">
        <div>
            {{-- <img src="{{ asset('images/DARA.png') }}" alt="Logo"> --}}
        </div>
        <div class="navbar-right">
            <div class="notification-wrapper">
                <button id="notifBtn" class="notif-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span id="notifBadge" class="notif-badge">0</span>
                </button>

                <div id="notifDropdown" class="notif-dropdown hidden">
                    <h4>Notifications</h4>
                    <ul id="notifList"></ul>
                </div>
            </div>

            <div class="profile">
                <div class="profile-info">
                    <p>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</p>
                    <p>Student</p>
                </div>
            </div>
        </div>
    </div>


    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div>
                <div class="menu-section">
                    <p class="menu-title">Menu</p>
                    <div class="menu">
                        <a href="<?php echo e(url('/student/dashboard')); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h4v11H3zM10 3h4v18h-4zM17 6h4v15h-4z" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="/">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" width="24" height="24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Search Studies
                        </a>
                        <a href="<?php echo e(url('/student/submission')); ?>" class="active">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Submit Studies
                        </a>
                        <a href="<?php echo e(url('/student/submitted')); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            Submitted Studies
                        </a>
                    </div>
                </div>

                <div class="menu-section">
                    <p class="menu-title">Settings</p>
                    <div class="menu">
                        <a href="<?php echo e(url('/student/account_setting')); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A1 1 0 015 17V7a1 1 0 011-1h3.382a1 1 0 01.894.553l1.382 2.764a1 1 0 00.894.553H19a1 1 0 011 1v6a1 1 0 01-.121.496l-2.382 4.764a1 1 0 01-.894.553H6a1 1 0 01-.879-.496z" />
                        </svg>
                        Account Settings
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>

                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                            </svg>
                            Log out
                        </a>

                    </div>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <main class="main">
            <h2>Submit a Document</h2>
            {{-- @if(session('success'))
                <div style="color: green; text-align: center; margin-bottom: 15px;">
                    {{ session('success') }}
                </div>
            @endif --}}
            <form id="documentForm" method="POST" enctype="multipart/form-data" action="{{ route('student.submit') }}">
            @csrf
            {{-- File Upload Box --}}
            <div class="upload-box">
                <p>📤 <a id="chooseFileBtn" style="cursor:pointer;">Click to Upload</a> File Supported: PDF (Max 25MB)</p>
                <input type="file" name="file" accept=".pdf" id="fileID" style="display:none;">
                <p id="fileNameDisplay" style="color: red; text-align:center;"></p>
            </div>

            {{-- Type of Studies --}}
            <p style="margin-top: 5px;"><strong>Type of Studies:</strong></p>
            <div class="type-buttons">
                <input type="checkbox" id="case" name="document_types[]" value="Case Study">
                <label for="case">Case Study</label>

                <input type="checkbox" id="thesis" name="document_types[]" value="Thesis">
                <label for="thesis">Thesis</label>

                <input type="checkbox" id="proposal" name="document_types[]" value="Proposal">
                <label for="proposal">Proposal</label>

                <input type="checkbox" id="capstone" name="document_types[]" value="Capstone">
                <label for="capstone">Capstone</label>

                <input type="checkbox" id="system" name="document_types[]" value="System Studies">
                <label for="system">System Studies</label>
            </div>

            {{-- Form Fields --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" id="title" name="title" placeholder="Enter title" value="{{ old('title') }}">
                    @error('title')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Keywords</label>
                    <input type="text" id="keywords" name="keywords" placeholder="Comma-separated keywords">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Abstract</label>
                    <textarea id="abstract" name="abstract" placeholder="Write abstract here..."></textarea>

                    <label style="margin-top: 1rem;">Citations (comma-separated)</label>
                    <input id="citations" type="text" name="citations" placeholder="e.g., Author 2023, Research 2022">
                </div>

            <div class="form-group">
                <label id="mainTeacherLabel">Teacher</label>
                <select id="teacher_id" name="teacher_id" class="teacher-select">
                    <option value="">-- Select Teacher --</option>
                    @foreach($teachers as $teacher)
                        <option value="{{ $teacher->user_id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                    @endforeach
                </select>

                <!-- Additional Teachers (Hidden by default) -->
                <div id="extraTeachers" class="teacher-container" style="display:none;">
                    <div class="teacher-group">
                        <label>Teacher 2</label>
                        <select name="teacher_id_2" class="teacher-select">
                            <option value="">-- Select Teacher --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->user_id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="teacher-group">
                        <label>Teacher 3</label>
                        <select name="teacher_id_3" class="teacher-select">
                            <option value="">-- Select Teacher --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->user_id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <label class="submit-date">Submission Date</label>
                <input type="date" id="submission_date" name="submission_date">
            </div>
        </div>

        <button class="submit-btn" type="submit">Submit</button>
        </form>
    </main>
</div>

{{-- JavaScript --}}

<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // --- File Upload + Title Autofill ---
    const chooseFileBtn = document.getElementById('chooseFileBtn');
    const fileInput = document.getElementById('fileID');
    const fileNameDisplay = document.getElementById('fileNameDisplay');
    const titleInput = document.getElementById('title');
    const form = document.getElementById('documentForm');

    chooseFileBtn.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const fileName = file.name;
            const baseName = fileName.replace(/\.[^/.]+$/, ""); // remove extension
            fileNameDisplay.textContent = `Selected: ${fileName}`;
            if (!titleInput.value.trim()) titleInput.value = baseName;
        } else {
            fileNameDisplay.textContent = '';
        }
    });

    // --- Unified Form Validation & Title Check ---
    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        document.querySelectorAll('.error-text').forEach(el => el.remove());

        let isValid = true;

        function showError(input, message) {
            const error = document.createElement('div');
            error.className = 'error-text';
            error.textContent = message;
            error.style.color = '#e74c3c';
            error.style.fontSize = '0.85rem';
            error.style.marginTop = '6px';
            input.insertAdjacentElement('afterend', error);
        }

        // Get fields
        const typeChecks = document.querySelectorAll('input[name="document_types[]"]:checked');
        const keywords = document.getElementById('keywords');
        const abstract = document.getElementById('abstract');
        const citations = document.getElementById('citations');
        const teacher = document.getElementById('teacher_id');
        const date = document.getElementById('submission_date');

        // --- File Validation ---
        if (fileInput.files.length === 0) {
            showError(document.querySelector('.upload-box'), 'Please upload a PDF file.');
            isValid = false;
        } else {
            const file = fileInput.files[0];
            if (file.size > 25 * 1024 * 1024) {
                showError(document.querySelector('.upload-box'), 'File size must not exceed 25MB.');
                isValid = false;
            }
            if (!file.name.toLowerCase().endsWith('.pdf')) {
                showError(document.querySelector('.upload-box'), 'Only PDF files are allowed.');
                isValid = false;
            }
        }

        // --- Type of Study ---
        if (typeChecks.length === 0) {
            showError(document.querySelector('.type-buttons'), 'Please select at least one study type.');
            isValid = false;
        }

        // --- Title ---
        const titleTrim = titleInput.value.trim();
        if (titleTrim === '') {
            showError(titleInput, 'Title is required.');
            isValid = false;
        } else if (titleTrim.length < 5 || titleTrim.length > 255) {
            showError(titleInput, 'Title must be between 5 and 255 characters.');
            isValid = false;
        }

        // --- Keywords ---
        if (keywords.value.trim() === '') {
            showError(keywords, 'Keywords are required.');
            isValid = false;
        }

        // --- Abstract ---
        const abstractTrim = abstract.value.trim();
        if (abstractTrim === '') {
            showError(abstract, 'Abstract is required.');
            isValid = false;
        } else if (abstractTrim.split(/\s+/).length < 10) {
            showError(abstract, 'Abstract must be at least 10 words.');
            isValid = false;
        }

        // --- Citations ---
        if (citations.value.trim() === '') {
            showError(citations, 'Citations are required.');
            isValid = false;
        }

        // --- Teacher ---
        if (teacher.value.trim() === '') {
            showError(teacher, 'Please select a teacher.');
            isValid = false;
        }

        // --- Date ---
        if (date.value.trim() === '') {
            showError(date, 'Submission date is required.');
            isValid = false;
        }

        // --- Stop here if invalid ---
        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Form Error',
                text: 'Please correct the highlighted fields before submitting.',
                confirmButtonColor: '#e74c3c'
            });
            return;
        }

        // --- Check for duplicate title ---
        try {
            const response = await fetch("{{ route('student.checkTitle') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ title: titleTrim })
            });

            const data = await response.json();

            if (data.exists) {
                Swal.fire({
                    title: 'Duplicate Title Found',
                    text: `A document with the same title already exists. Would you like to submit as "${data.next_title}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Proceed',
                    cancelButtonText: 'Cancel'
                }).then(result => {
                    if (result.isConfirmed) {
                        titleInput.value = data.next_title;
                        form.submit();
                    }
                });
            } else {
                form.submit();
            }
        } catch (error) {
            console.error('Error checking title:', error);
            Swal.fire('Error', 'An unexpected error occurred. Please try again.', 'error');
        }
    });

    // Prevent selecting past dates
    const dateInput = document.getElementById('submission_date');
    const today = new Date().toISOString().split('T')[0];
    dateInput.min = today;

    // SweetAlert Success Message (if redirected)
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 2500
    });
    @endif
    </script>

    <script>
        async function loadNotifications(saveToStorage = true) {
        const notifBadge = document.getElementById('notifBadge');
        const notifList = document.getElementById('notifList');

        try {
            const res = await fetch('{{ route("student.notifications") }}');
            const data = await res.json();

            notifList.innerHTML = '';

            if (data.length === 0) {
            notifBadge.style.display = 'none';
            notifList.innerHTML = '<li>No new notifications.</li>';
            if (saveToStorage) localStorage.setItem('notifCount', 0);
            return;
            }

            // Get read notifications from localStorage
            const readNotifs = JSON.parse(localStorage.getItem('readNotifs') || '[]');

            // Filter unread notifications for badge
            const unreadCount = data.filter(n => !readNotifs.includes(n.message)).length;

            notifBadge.style.display = unreadCount > 0 ? 'inline-block' : 'none';
            notifBadge.textContent = unreadCount;

            // store count so it persists across pages
            if (saveToStorage) localStorage.setItem('notifCount', unreadCount);

            data.forEach(n => {
            const li = document.createElement('li');

            // If notification has been read, bg is white; else yellow
            const isRead = readNotifs.includes(n.message);
            li.style.backgroundColor = isRead ? '#fff' : '#fef9c3';
            li.style.cursor = 'pointer';
            li.innerHTML = `
                ${n.icon}
                <a href="${n.link}" class="notif-link">${n.message}</a>
                <br>
                <small>${n.time}</small>
            `;

            // On click: mark as read, set bg white, update badge
            li.addEventListener('click', () => {
                if (!readNotifs.includes(n.message)) {
                readNotifs.push(n.message);
                localStorage.setItem('readNotifs', JSON.stringify(readNotifs));

                li.style.backgroundColor = '#fff';

                // update badge
                const currentBadge = parseInt(notifBadge.textContent) || 0;
                const newBadge = Math.max(currentBadge - 1, 0);
                notifBadge.textContent = newBadge;
                if (newBadge === 0) notifBadge.style.display = 'none';
                }
            });

            notifList.appendChild(li);
            });
        } catch (error) {
            console.error('Error loading notifications:', error);
        }
        }

        // --- INITIALIZATION ---
        document.addEventListener('DOMContentLoaded', () => {
        const notifBadge = document.getElementById('notifBadge');

        // Load saved count from localStorage (keep number after page change)
        const savedCount = localStorage.getItem('notifCount');
        if (savedCount && parseInt(savedCount) > 0) {
            notifBadge.textContent = savedCount;
            notifBadge.style.display = 'inline-block';
        } else {
            notifBadge.style.display = 'none';
        }

        // Fetch new notifications immediately
        loadNotifications();

        // Refresh notifications every 10 seconds
        setInterval(() => {
            loadNotifications();
        }, 10000); // 10 seconds
        });

        // Toggle dropdown on bell click
        document.getElementById('notifBtn').addEventListener('click', async () => {
        const dropdown = document.getElementById('notifDropdown');
        dropdown.classList.toggle('hidden');
        if (!dropdown.classList.contains('hidden')) {
            await loadNotifications(false); // don’t overwrite saved count every click
        }
        });
    </script>
</body>
</html>
