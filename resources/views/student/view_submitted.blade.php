<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D.A.R.A Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/teacher/view_submitted.css') }}">
</head>
<body>

  <!-- Navbar -->
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

  <!-- Layout -->
  <div class="layout">
      <!-- Sidebar -->
      <aside class="sidebar">
          <div>
              <div class="menu-section">
                  <p class="menu-title">Menu</p>
                  <div class="menu">
                      <a href="{{ url('/student/dashboard') }}">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                              viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 10h4v11H3zM10 3h4v18h-4zM17 6h4v15h-4z" />
                          </svg>
                          Dashboard
                      </a>
                      <a href="{{ url('/student/dashboard') }}">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                              viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                          </svg>
                          Search Studies
                      </a>
                      <a href="<?php echo e(url('/student/submission')); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                            </svg>
                            Submit Studies
                        </a>
                        <a href="{{ url('/student/submitted') }}" class="active">
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
                      <a href="{{ url('/student/account_setting') }}">
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

                      <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                              stroke="currentColor" class="w-5 h-5">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7" />
                          </svg>
                          Log out
                      </a>
                  </div>
              </div>
          </div>
      </aside>

      <!-- Main -->
      <main class="main">
          <h2>Review Submitted Study</h2>

          <div class="viewContainer">
              <!-- Left: document info -->
              <div class="par">
                  <p><strong>Title:</strong> {{ $document->title ?? 'N/A' }}</p>
                  <p><strong>Abstract:</strong> {{ $document->abstract ?? 'No abstract provided.' }}</p>
                  <p><strong>Study Type:</strong> {{ $document->study_type ?? 'N/A' }}</p>

                  <p><strong>Date Submitted:</strong>
                      {{ $document->date_submitted ? $document->date_submitted->format('F d, Y') : 'N/A' }}
                  </p>

                  @php
                      $status = strtolower($document->status ?? 'pending');
                  @endphp
                  <p><strong>Status:</strong>
                      <span class="status-badge {{ $status }}">
                          {{ ucfirst($status) }}
                      </span>
                  </p>
              </div>

              <!-- Right: Action buttons -->
              <div>
                  <form id="abandonForm" method="POST" action="{{ route('student.abandon', $document->document_id) }}">
                      @csrf
                      @method('DELETE')
                      <button type="button" id="abandonBtn" class="par-btn" style="background-color:#ff4d4d;">
                          ❌ Abandon Document
                      </button>
                      <a href="{{ url('/student/submitted') }}" class="par-btn">
                          🔙 Go Back
                      </a>
                  </form>
              </div>
          </div>

          {{-- PDF Viewer --}}
          <div class="pdfview">
              @if(!empty($document->file) && file_exists(public_path('storage/' . $document->file)))
                  <embed src="{{ asset('storage/' . $document->file) }}"
                      type="application/pdf"
                      width="100%" height="600px"
                      style="border-radius: 20px;">
              @else
                  <div class="no-file">
                      <p>No PDF file found for this document.</p>
                  </div>
              @endif
          </div>
      </main>
  </div>

    {{-- SweetAlert Dialog --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const abandonBtn = document.getElementById('abandonBtn');
            const documentId = '{{ $document->document_id }}';
            let currentStatus = '{{ strtolower($document->status) }}';

            function updateButton(status) {
                if (status === 'abandoned') {
                    abandonBtn.textContent = '♻️ Revert Document';
                    abandonBtn.style.backgroundColor = '#4CAF50';
                } else {
                    abandonBtn.textContent = '❌ Abandon Document';
                    abandonBtn.style.backgroundColor = '#ff4d4d';
                }
                currentStatus = status;
            }

            updateButton(currentStatus);

            abandonBtn.addEventListener('click', function() {
                let actionText = currentStatus === 'abandoned' ? 'Revert this document?' : 'Abandon this document?';
                let confirmBtn = currentStatus === 'abandoned' ? 'Revert' : 'Abandon';

                Swal.fire({
                    title: actionText,
                    text: 'This action can be undone only if reverting.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: confirmBtn,
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/student/view_submitted/${documentId}/toggle-abandon`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: data.message,
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                updateButton(data.status);
                                document.querySelector('.status-badge').textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                                document.querySelector('.status-badge').className = 'status-badge ' + data.status;
                            } else {
                                Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                            }
                        });
                    }
                });
            });
        });
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
