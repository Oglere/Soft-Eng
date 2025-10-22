<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D.A.R.A Review</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/teacher/review.css') }}">
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
        <h1>D.A.R.A</h1>

        <div class="navbar-right">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>

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
                        <a href="<?php echo e(url('/teacher/review')); ?>" class="active">
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
    <h2>Submitted Studies</h2>
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                <tr data-status="{{ strtolower($doc->status ?? 'pending') }}">
                    <td>
                    <a href="{{ url('/teacher/review/' . $doc->document_id) }}" class="plain-link">
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
                    <td style="text-align: center;">
                    <button
                        class="action-btn view-btn"
                        data-title="{{ $doc->title }}"
                        data-sender="{{ $student?->first_name . ' ' . $student?->last_name }}"
                        data-date="{{ \Carbon\Carbon::parse($doc->date_submitted)->format('M d, Y') }}"
                        data-status="{{ ucfirst($doc->status ?? 'Pending') }}"
                        data-study-type="{{ $doc->study_type ?? 'N/A' }}"
                        data-abstract="{{ $doc->abstract ?? 'No abstract provided.' }}"
                        data-file-url="{{ $doc->file ? asset('storage/documents/' . $doc->file) : '' }}"
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
        {{-- <div class="pagination-container">
            {{ $documents->withQueryString()->links('vendor.pagination.custom') }}
        </div> --}}

        <!-- Modal -->
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

                    <div id="modalPdfContainer" style="height:400px;">
                    <iframe id="modalFilePdf" src="" style="width:100%; height:100%; border:1px solid #ccc; border-radius:6px;"></iframe>
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
        let currentFilter = "{{ request('status') ?? 'all' }}";

        function filterRows() {
            const query = searchInput.value.toLowerCase();
            let anyVisible = false;

            rows.forEach(row => {
            const titleCell = row.querySelector('td:first-child');
            if (!titleCell) return;

            const title = titleCell.innerText.toLowerCase();
            const studyType = row.children[3]?.innerText.toLowerCase() || '';
            const status = row.getAttribute('data-status');

            const matchesSearch = title.includes(query) || studyType.includes(query);
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
            td.setAttribute('colspan', 5);
            td.innerText = `No ${currentFilter === 'all' ? 'studies' : currentFilter + ' studies'} found.`;
            td.style.textAlign = 'center';
            td.style.color = 'gray';
            noRow.appendChild(td);
            tbody.appendChild(noRow);
            }
        }

        searchInput.addEventListener('input', filterRows);

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            currentFilter = button.dataset.status;
            filterRows();
            });
        });

        filterRows();
        });

        // Modal logic
        const modal = document.getElementById('reviewModal');
        const modalTitle = document.getElementById('modalTitle');
        const modalSender = document.getElementById('modalSender');
        const modalDate = document.getElementById('modalDate');
        const modalStatus = document.getElementById('modalStatus');
        const modalStudyType = document.getElementById('modalStudyType');
        const modalAbstract = document.getElementById('modalAbstract');
        const modalFilePdf = document.getElementById('modalFilePdf');
        const modalPdfContainer = document.getElementById('modalPdfContainer');
        const modalClose = document.getElementById('modalClose');

        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                modalTitle.innerText = btn.dataset.title;
                modalSender.innerText = btn.dataset.sender;
                modalDate.innerText = btn.dataset.date;
                modalStatus.innerText = btn.dataset.status;
                modalStudyType.innerText = btn.dataset.studyType;
                modalAbstract.innerText = btn.dataset.abstract;

                if (btn.dataset.fileUrl) {
                modalPdfContainer.style.display = 'block';
                modalFilePdf.src = btn.dataset.fileUrl;
                } else {
                modalPdfContainer.style.display = 'none';
                modalFilePdf.src = '';
                }

                modal.style.display = 'flex';
            });
        });
            modalClose.addEventListener('click', () => {
            modal.style.display = 'none';
            modalFilePdf.src = '';
            });

            window.addEventListener('click', e => {
            if (e.target === modal) {
                modal.style.display = 'none';
                modalFilePdf.src = '';
            }
        });
    </script>
</div>
</body>
</html>
