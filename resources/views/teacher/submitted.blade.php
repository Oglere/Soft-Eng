<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D.A.R.A Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/teacher/submitted.css') }}">
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
                    <span id="notifBadge" class="notif-badge" style="display:none;">0</span>
                </button>

                <div id="notifDropdown" class="notif-dropdown hidden">
                    <h4>Notifications</h4>
                    <ul id="notifList"></ul>
                </div>
            </div>
            <div class="profile">

                <div class="profile-info">
                    <p>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</p>

                    <p>Teacher</p>
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
                        <a href="<?php echo e(url('/teacher/dashboard')); ?>">
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
                        <a href="<?php echo e(url('/teacher/submitted')); ?>" class="active">
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
                            <a href="<?php echo e(url('/teacher/account_setting')); ?>">
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
    <h2>Review Studies</h2>
        <div class="search-filter">
            <!-- Search Bar -->
            <div class="search-bar">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" class="search-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35m2.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" id="searchInput" placeholder="Search by title or study type..." value="{{ request('keyword') }}">
            </div>

            <!-- Filter Buttons -->
            <div class="filters">
                <button data-status="all" class="{{ (request('status') ?? 'all') === 'all' ? 'active' : '' }}">All</button>
                <button data-status="pending" class="{{ request('status') === 'pending' ? 'active' : '' }}">Pending</button>
                <button data-status="approved" class="{{ request('status') === 'approved' ? 'active' : '' }}">Approved</button>
                <button data-status="revision" class="{{ request('status') === 'revision' ? 'active' : '' }}">For Revision</button>
                <button data-status="rejected" class="{{ request('status') === 'rejected' ? 'active' : '' }}">Rejected</button>
            </div>
        </div>

        <!-- Review Table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Sent By</th>
                    <th>Date Submitted</th>
                    <th>Study Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                <tr data-status="{{ strtolower($doc->status ?? 'pending') }}">
                    <td>
                    <a href="{{ url('/teacher/view_submitted/' . $doc->document_id) }}" class="plain-link">
                        {{ $doc->title ?? 'Untitled Study' }}
                    </a>
                    </td>
                    <td>
                    @php
                        $student = \App\Models\User::where('user_id', $doc->student_id)->first();
                    @endphp
                    {{ $student?->first_name }} {{ $student?->last_name }}
                    </td>
                    <td>{{ \Carbon\Carbon::parse($doc->date_submitted)->format('M d, Y') }}</td>
                    <td>{{ $doc->study_type ?? 'N/A' }}</td>
                    <td>
                        @php
                            $status = strtolower($doc->status ?? 'pending');
                            $statusClass = match($status) {
                                'approved' => 'approved',
                                'needs revision', 'revision' => 'revision',
                                'rejected' => 'rejected',
                                'pending' => 'pending',
                                default => 'unknown'
                            };
                        @endphp
                        <span class="status {{ $statusClass }}">{{ ucfirst($status) }}</span>
                    </td>
                    <td style="text-align: center;">
                    <button
                            class="action-btn view-btn"
                            data-id="{{ $doc->document_id }}"
                            data-title="{{ $doc->title }}"
                            data-sender="{{ $student?->first_name . ' ' . $student?->last_name }}"
                            data-date="{{ \Carbon\Carbon::parse($doc->date_submitted)->format('M d, Y') }}"
                            data-status="{{ ucfirst($doc->status ?? 'Pending') }}"
                            data-study-type="{{ $doc->study_type ?? 'N/A' }}"
                            data-abstract="{{ $doc->abstract ?? 'No abstract provided.' }}"
                            data-file-url="{{ $doc->file ? asset('storage/' . $doc->file) : '' }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5
                                c4.477 0 8.268 2.943 9.542 7
                                -1.274 4.057-5.065 7-9.542 7
                                -4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; color:gray;">No studies found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination-container">
            {{ $documents->withQueryString()->links('vendor.pagination.custom') }}
        </div>

        <!-- Review Modal -->
        <div id="reviewModal" class="modal" style="display:none;">
            <div class="modal-content">
                <button id="modalClose" class="modal-close">&times;</button>
                <h2 id="modalTitle"></h2>
                <div class="modal-body">
                    <p><strong>Sent By:</strong> <span id="modalSender"></span></p>
                    <p><strong>Date Submitted:</strong> <span id="modalDate"></span></p>
                    <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                    <p><strong>Study Type:</strong> <span id="modalStudyType"></span></p>

                    <p><strong>Abstract:</strong></p>
                    <p id="modalAbstract" class="scrollable-text"></p>

                    <!-- PDF Viewer -->
                    <div id="modalPdfContainer" style="height:400px; margin-top: 1rem;">
                        <iframe
                            id="modalFilePdf"
                            src=""
                            style="width:100%; height:100%; border:1px solid #ccc; border-radius:6px; display:none;">
                        </iframe>
                        <div id="noFileMessage" class="no-file" style="text-align:center; padding:20px; color:gray; display:none;">
                            <p>No PDF file found for this document.</p>
                        </div>
                    </div>

                    <div style="margin-top: 1rem; text-align: right;">
                        <a id="reviewButton" href="#" class="review-btn">Review Submitted Studies</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- JS Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const filterButtons = document.querySelectorAll('.filters button');
            const tbody = document.querySelector('.table tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            let currentFilter = "{{ $filter ?? 'all' }}"; // initial filter from URL

            function filterRows() {
                const query = searchInput.value.toLowerCase();
                let anyVisible = false;

                rows.forEach(row => {
                    const titleCell = row.querySelector('td:first-child');
                    if (!titleCell) return;

                    const title = titleCell.innerText.toLowerCase();
                    const status = row.getAttribute('data-status');

                    const matchesSearch = title.includes(query);
                    const matchesFilter = currentFilter === 'all' || status === currentFilter;

                    if (matchesSearch && matchesFilter) {
                        row.style.display = '';
                        anyVisible = true;
                    } else {
                        row.style.display = 'none';
                    }
                });

                const existingNoResult = tbody.querySelector('.no-results');
                if (existingNoResult) existingNoResult.remove();

                if (!anyVisible) {
                    const noRow = document.createElement('tr');
                    noRow.classList.add('no-results');
                    const td = document.createElement('td');
                    td.setAttribute('colspan', 4);

                    let statusText = currentFilter.charAt(0).toUpperCase() + currentFilter.slice(1);
                    if (currentFilter === 'all') statusText = 'submitted';
                    else if (currentFilter === 'revision') statusText = 'For Revision';

                    td.innerText = `No ${statusText} document yet.`;
                    td.style.textAlign = 'center';
                    td.style.color = 'gray';
                    noRow.appendChild(td);
                    tbody.appendChild(noRow);
                }
            }

            // Search event
            searchInput.addEventListener('input', filterRows);

            // Status buttons
            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');

                    currentFilter = button.textContent.toLowerCase().replace(/\s+/g, '');
                    if(currentFilter === 'forrevision') currentFilter = 'revision';

                    filterRows();
                });
            });

            // Apply filter from URL on page load
            filterRows();
        });

        const modal = document.getElementById('reviewModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalSender = document.getElementById('modalSender');
        const modalDate = document.getElementById('modalDate');
        const modalStatus = document.getElementById('modalStatus');
        const modalStudyType = document.getElementById('modalStudyType');
        const modalAbstract = document.getElementById('modalAbstract');
        const modalFilePdf = document.getElementById('modalFilePdf');
        const noFileMessage = document.getElementById('noFileMessage');
        const modalClose = document.getElementById('modalClose');

        // View button logic
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                // Populate modal fields dynamically
                modalTitle.innerText = btn.dataset.title || 'Untitled Study';
                modalSender.innerText = btn.dataset.sender || 'Unknown Student';
                modalDate.innerText = btn.dataset.date || 'N/A';
                modalStatus.innerText = btn.dataset.status || 'Pending';
                modalStudyType.innerText = btn.dataset.studyType || 'N/A';
                modalAbstract.innerText = btn.dataset.abstract || 'No abstract provided.';

                // Handle PDF viewer
                const pdfUrl = btn.dataset.fileUrl?.trim();
                if (pdfUrl) {
                    modalFilePdf.src = pdfUrl + '#toolbar=0';
                    modalFilePdf.style.display = 'block';
                    noFileMessage.style.display = 'none';
                } else {
                    modalFilePdf.src = '';
                    modalFilePdf.style.display = 'none';
                    noFileMessage.style.display = 'block';
                }

                // Add dynamic review button link
                const reviewButton = document.getElementById('reviewButton');
                reviewButton.href = `/teacher/view_submitted/${btn.dataset.id}`;

                // Show modal
                modal.style.display = 'flex';
            });
        });

        // Close modal
        modalClose.addEventListener('click', () => {
            modal.style.display = 'none';
            modalFilePdf.src = '';
        });

        // Close modal when clicking outside
        window.addEventListener('click', e => {
            if (e.target === modal) {
                modal.style.display = 'none';
                modalFilePdf.src = '';
            }
        });


        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const notifStatus = urlParams.get('status'); // e.g. approved
            const notifDocId = urlParams.get('doc_id');  // e.g. 5

            if (notifStatus && notifDocId) {
                // Find the exact row (status + doc_id must match)
                const row = document.querySelector(
                    `tr[data-status="${notifStatus.toLowerCase()}"][data-id="${notifDocId}"]`
                );

                if (row) {
                    row.classList.add('highlight');
                    row.scrollIntoView({ behavior: 'smooth', block: 'center' });

                    // Remove highlight after 5 seconds
                    setTimeout(() => {
                        row.classList.remove('highlight');
                    }, 5000);
                }
            }
        });
    </script>
<script>
    async function loadNotifications(saveToStorage = true) {
        const notifBadge = document.getElementById('notifBadge');
        const notifList = document.getElementById('notifList');

        try {
            // Fetch teacher notifications
            const res = await fetch('{{ route("teacher.notifications") }}');
            const data = await res.json();

            notifList.innerHTML = '';

            if (data.length === 0) {
                notifBadge.style.display = 'none';
                notifList.innerHTML = '<li>No new notifications.</li>';
                if (saveToStorage) localStorage.setItem('teacherNotifCount', 0);
                return;
            }

            // Get read notifications from localStorage
            const readNotifs = JSON.parse(localStorage.getItem('teacherReadNotifs') || '[]');

            // Filter unread notifications for badge
            const unreadCount = data.filter(n => !readNotifs.includes(n.message)).length;

            notifBadge.style.display = unreadCount > 0 ? 'inline-block' : 'none';
            notifBadge.textContent = unreadCount;

            if (saveToStorage) localStorage.setItem('teacherNotifCount', unreadCount);

            data.forEach(n => {
                const li = document.createElement('li');
                const isRead = readNotifs.includes(n.message);
                li.style.backgroundColor = isRead ? '#fff' : '#fef9c3';
                li.style.cursor = 'pointer';
                li.innerHTML = `
                    ${n.icon}
                    <a href="${n.link}" class="notif-link">${n.message}</a>
                    <br>
                    <small>${n.time}</small>
                `;

                li.addEventListener('click', () => {
                    if (!readNotifs.includes(n.message)) {
                        readNotifs.push(n.message);
                        localStorage.setItem('teacherReadNotifs', JSON.stringify(readNotifs));
                        li.style.backgroundColor = '#fff';

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

        // Load saved count from localStorage
        const savedCount = localStorage.getItem('teacherNotifCount');
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
        }, 10000);
    });

    // Toggle dropdown on bell click
    document.getElementById('notifBtn').addEventListener('click', async () => {
        const dropdown = document.getElementById('notifDropdown');
        dropdown.classList.toggle('hidden');
        if (!dropdown.classList.contains('hidden')) {
            await loadNotifications(false);
        }
    });
</script>
</div>
</body>
</html>
