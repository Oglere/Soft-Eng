@extends('layout.student')
<link rel="stylesheet" href="{{ asset('css/student/doc_status.css') }}">

@section('right')
<h1>STATUS OF SUBMITTED DOCUMENTS</h1>

<div class="table-controls">
    <div class="filter-search-container">
        <!-- Search Input -->
        <div class="search-wrapper">
            <input type="text" id="searchInput" placeholder="Search by title...">
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
				stroke-width="1.5" stroke="currentColor" class="search-icon">
				<path stroke-linecap="round" stroke-linejoin="round"
					d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"/>
			</svg>
        </div>

		<!-- Filter Dropdown -->
        <select id="statusFilter">
            <option value="all">All</option>
            <option value="approved">Approved</option>
            <option value="revision">For Revision</option>
            <option value="rejected">Rejected</option>
            <option value="pending">Pending</option>
        </select>
    </div>
</div>

<!-- Table Display -->
<div class="table-container">
    <table id="statusTable">
        <thead>
            <tr>
                <th>Title</th>
                <th style="text-align: center;">Date Submitted</th>
                <th style="text-align: center;">Status</th>
                <th style="text-align: center;">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($submissions as $submission)
                <tr data-status="{{ strtolower($submission->status) }}">
                    <td>
                        <a href="{{ route('student.view_status', ['id' => $submission->document_id]) }}">
                            {{ $submission->title ?? 'Untitled Document' }}
                        </a>
                    </td>
                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($submission->date_submitted)->format('M d, Y') }}</td>
                    <td class="status-cell" style="text-align: center;">
                        @if($submission->status === 'pending')
                            <span class="status pending">Pending</span>
                        @elseif($submission->status === 'approved')
                            <span class="status approved">Approved</span>
                        @elseif($submission->status === 'rejected')
                            <span class="status rejected">Rejected</span>
                        @elseif($submission->status === 'revision')
                            <span class="status revision">For Revision</span>
                        @else
                            <span class="status unknown">Unknown</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('student.view_status', ['id' => $submission->document_id]) }}" class="edit-btn" title="Edit">
                            <svg style="margin: 0;" xmlns="http://www.w3.org/2000/svg" fill="none" 
                                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                 class="edit-icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652l-10.5 10.5a4.5 4.5 0 01-1.897 1.13l-4.005 1.07 1.07-4.006a4.5 4.5 0 011.13-1.897l10.863-10.861z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M19.5 7.125L16.875 4.5" />
                            </svg>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center; color:gray;">No submitted documents yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

<script src="{{asset('js/student/sweetalert2@11.js')}}"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const rows = document.querySelectorAll('#statusTable tbody tr');

    // 🔍 Search functionality
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        rows.forEach(row => {
            const title = row.querySelector('td:first-child').innerText.toLowerCase();
            row.style.display = title.includes(query) ? '' : 'none';
        });
    });

    // ⚙️ Filter by status
    statusFilter.addEventListener('change', () => {
        const filter = statusFilter.value.toLowerCase();
        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            row.style.display = (filter === 'all' || status === filter) ? '' : 'none';
        });
    });
});
</script>
