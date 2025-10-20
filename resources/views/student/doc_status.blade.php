<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>D.A.R.A - Submitted Documents</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
  <link rel="stylesheet" href="{{ asset('css/student/doc_status.css') }}">
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
            <a href="<?php echo e(url('/student/submission')); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4" />
              </svg>
              Submit Studies
            </a>
            <a href="<?php echo e(url('/student/doc_status')); ?>" class="active">
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
              Account
            </a>
            <a href="<?php echo e(url('/auth/login')); ?>">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
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
      <h2>Submitted Documents</h2>

      <div class="search-filter">
      <div class="search-bar">
  <svg xmlns="http://www.w3.org/2000/svg" fill="none"
    viewBox="0 0 24 24" stroke="currentColor" class="search-icon">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
      d="M21 21l-4.35-4.35m2.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
  </svg>
  <input type="text" id="searchInput" placeholder="Search by title">
</div>



        <div class="filters">
    <button class="{{ ($filter ?? 'all') === 'all' ? 'active' : '' }}">All</button>
    <button class="{{ ($filter ?? '') === 'approved' ? 'active' : '' }}">Approved</button>
    <button class="{{ ($filter ?? '') === 'revision' ? 'active' : '' }}">For Revision</button>
    <button class="{{ ($filter ?? '') === 'rejected' ? 'active' : '' }}">Rejected</button>
    <button class="{{ ($filter ?? '') === 'pending' ? 'active' : '' }}">Pending</button>
</div>

      </div>

   <table class="table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Submitted Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($submissions as $submission)
        <tr data-status="{{ strtolower($submission->status) }}">
            <td>
                <a href="{{ route('student.view_status', ['id' => $submission->document_id]) }}" class="plain-link">
                    {{ $submission->title ?? 'Untitled Document' }}
                </a>
            </td>
            <td>{{ \Carbon\Carbon::parse($submission->date_submitted)->format('M d, Y') }}</td>
            <td>
                @php
                    $statusClass = match(strtolower($submission->status)) {
                        'approved' => 'approved',
                        'revision' => 'revision',
                        'rejected' => 'rejected',
                        'pending' => 'pending',
                        default => 'unknown'
                    };
                    $statusText = match(strtolower($submission->status)) {
                        'approved' => 'Approved',
                        'revision' => 'For Revision',
                        'rejected' => 'Rejected',
                        'pending' => 'Pending',
                        default => 'Unknown'
                    };
                @endphp
                <span class="status {{ $statusClass }}">{{ $statusText }}</span>
            </td>
         <td>
<button 
    class="action-btn view-btn" 
    data-title="{{ $submission->title }}" 
    data-date="{{ \Carbon\Carbon::parse($submission->date_submitted)->format('M d, Y') }}" 
    data-status="{{ $statusText }}" 
    data-abstract="{{ $submission->abstract ?? 'No abstract provided.' }}"
    data-citation="{{ $submission->citation ?? 'No citation provided.' }}"
    data-study_type="{{ $submission->study_type ?? 'N/A' }}"
    data-file-url="{{ $submission->file ? asset('storage/documents/'.$submission->file) : '' }}"
    data-approved-by="{{ $submission->approved_by ? $submission->approver->first_name.' '.$submission->approver->last_name : '' }}"
>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
            <td colspan="4" style="text-align:center; color:gray;">No submitted documents yet.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination container -->
<div class="pagination-container">
    {{ $submissions->withQueryString()->links('vendor.pagination.custom') }}
</div>
<!-- Modal -->
<div id="submissionModal" class="modal" style="display:none;">
  <div class="modal-content">
    <button id="modalClose" class="modal-close">&times;</button>
    <h2 id="modalTitle"></h2>
    <div class="modal-body">
      <p><strong>Submitted Date:</strong> <span id="modalDate"></span></p>
      <p><strong>Status:</strong> <span id="modalStatus"></span></p>


      <p id="modalApprovedByContainer" style="display:none;">
        <strong>Approved By:</strong> <span id="modalApprovedBy"></span>
      </p>
      <p><strong>Citation:</strong> <span id="modalCitation"></span></p>
      <p><strong>Abstract:</strong></p>
      <p id="modalAbstract" class="scrollable-text"></p>

      <div id="modalPdfContainer" style="height:400px;">
          <iframe id="modalFilePdf" src="" style="width:100%; height:100%; border:1px solid #ccc; border-radius:6px;"></iframe>
      </div>
    </div>
  </div>
</div>


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

const modal = document.getElementById('submissionModal');
const modalTitle = document.getElementById('modalTitle');
const modalDate = document.getElementById('modalDate');
const modalStatus = document.getElementById('modalStatus');
const modalAbstract = document.getElementById('modalAbstract');
const modalCitation = document.getElementById('modalCitation');
const modalFilePdf = document.getElementById('modalFilePdf');
const modalPdfContainer = document.getElementById('modalPdfContainer');
const modalApprovedByContainer = document.getElementById('modalApprovedByContainer');
const modalApprovedBy = document.getElementById('modalApprovedBy');
const modalClose = document.getElementById('modalClose');

// View button logic
document.querySelectorAll('.view-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        modalTitle.innerText = btn.dataset.title;
        modalDate.innerText = btn.dataset.date;
        modalStatus.innerText = btn.dataset.status;
        modalAbstract.innerText = btn.dataset.abstract;
        modalCitation.innerText = btn.dataset.citation;

        // ✅ Always display the PDF if file exists
        if (btn.dataset.fileUrl) {
            modalPdfContainer.style.display = 'block';
            modalFilePdf.src = btn.dataset.fileUrl;
        } else {
            modalPdfContainer.style.display = 'none';
            modalFilePdf.src = '';
        }

        // ✅ Only show “Approved By” if status is approved
        if (btn.dataset.status.toLowerCase() === 'approved' && btn.dataset.approvedBy) {
            modalApprovedByContainer.style.display = 'block';
            modalApprovedBy.innerText = btn.dataset.approvedBy;
        } else {
            modalApprovedByContainer.style.display = 'none';
            modalApprovedBy.innerText = '';
        }

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
</script>


    </main>
  </div>
</body>
</html>
