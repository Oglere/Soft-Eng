<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

@extends('layout.teacher')

@section('right')
<style>
/* Review Studies Page Styles */
.review-page {
    padding: 40px 25px;
    font-family: 'Poppins', sans-serif;
}

.review-page h1 {
    color: #0e100f;
    font-weight: 700;
    text-align: center;
    margin-bottom: 40px;
}

/* Search & Filters */
.review-filters {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

.review-filters .input-group {
    display: flex;
    border-radius: 50px;
    overflow: hidden;
    max-width: 320px;
    width: 100%;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}

.review-filters input {
    border: none;
    padding: 10px 15px;
    width: 100%;
    outline: none;
    font-size: 15px;
}

.review-filters button {
    background-color: #0e100f;
    color: #fff;
    border: none;
    padding: 10px 18px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.review-filters button:hover {
    background-color: #0403a0;
}

.filter-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    justify-content: center;
}

.filter-buttons a {
    border-radius: 50px;
    padding: 6px 14px;
    font-size: 14px;
    border: 1px solid #ccc;
    text-decoration: none;
    transition: all 0.3s ease;
}

.filter-buttons a:hover {
    transform: translateY(-2px);
}

/* Table Styles */
.review-table {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

.review-table table {
    width: 100%;
    border-collapse: collapse;
}

.review-table thead {
    background-color: #0e100f;
    color: #fff;
    font-weight: 600;
}

.review-table th,
.review-table td {
    padding: 12px 10px;
    text-align: center;
    border-bottom: 1px solid #ddd;
    vertical-align: middle;
}

.review-table tr:last-child td {
    border-bottom: none;
}

.review-table a {
    color: #0e100f;
    font-weight: 600;
    text-decoration: none;
}

.review-table a:hover {
    text-decoration: underline;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    border-radius: 20px;
    padding: 4px 10px;
    font-size: 13px;
    font-weight: 600;
    color: white;
}

.status-pending {
    background-color: #ffc107;
}
.status-approved {
    background-color: #198754;
}
.status-rejected {
    background-color: #dc3545;
}
.status-revision {
    background-color: #0d6efd;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    justify-content: center;
    gap: 8px;
}

.action-buttons .btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.action-buttons .btn:hover {
    transform: scale(1.1);
}

.btn-success {
    background-color: #198754;
    color: white;
}

.btn-primary {
    background-color: #030281;
    color: white !important;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    gap: 5px;
    list-style: none;
    padding: 0;
    margin-top: 20px;
}

.pagination li {
    display: inline;
}

.pagination a,
.pagination span {
    padding: 8px 12px;
    border-radius: 8px;
    border: 1px solid #ddd;
    text-decoration: none;
    color: #0e100f;
    font-size: 14px;
}

.pagination .active span {
    background-color: #0e100f;
    color: white;
    border-color: #0e100f;
}

@media (max-width: 768px) {
    .review-filters {
        flex-direction: column;
        gap: 10px;
    }

    .filter-buttons {
        justify-content: center;
    }

    .review-table table {
        font-size: 14px;
    }

    .action-buttons .btn {
        width: 28px;
        height: 28px;
    }
}
</style>

<div class="review-page">
    <h1>Review Studies</h1>

    {{-- Search + Filters --}}
    <form method="GET" action="{{ route('teacher.review.list') }}" class="review-filters">
        <div class="input-group">
            <input type="text" name="keyword" placeholder="Search by title or study type..." value="{{ request('keyword') }}">
            <button type="submit"><i class="bi bi-search"></i></button>
        </div>

        <div class="filter-buttons">
            <a href="{{ route('teacher.review.list', ['status' => 'pending']) }}" class="{{ request('status')=='pending' ? 'btn btn-primary text-white' : '' }}">Pending</a>
            <a href="{{ route('teacher.review.list', ['status' => 'approved']) }}" class="{{ request('status')=='approved' ? 'btn btn-success text-white' : '' }}">Approved</a>
            <a href="{{ route('teacher.review.list', ['status' => 'revision']) }}" class="{{ request('status')=='revision' ? 'btn btn-info text-white' : '' }}">Revision</a>
            <a href="{{ route('teacher.review.list', ['status' => 'rejected']) }}" class="{{ request('status')=='rejected' ? 'btn btn-danger text-white' : '' }}">Rejected</a>
            <a href="{{ route('teacher.review.list', ['status' => 'all']) }}" class="{{ request('status')=='all' || !request('status') ? 'btn btn-dark text-white' : '' }}">All</a>
        </div>
    </form>

    {{-- Results Table --}}
    <div class="review-table">
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Sent By</th>
                    <th>Date</th>
                    <th>Study Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                    <tr>
                        <td>
                            <a href="{{ '/teacher/review-document/' . $doc->document_id }}">
                                {{ $doc->title }}
                            </a>
                        </td>
                        <td>
                            {{ optional(\App\Models\User::where('user_id', $doc->student_id)->first())->first_name }}
                            {{ optional(\App\Models\User::where('user_id', $doc->student_id)->first())->last_name }}
                        </td>
                        <td>{{ \Carbon\Carbon::parse($doc->date_submitted)->format('d/m/y') }}</td>
                        <td>{{ $doc->study_type }}</td>

                        {{-- Status --}}
                        <td>
                            @php
                                $status = strtolower($doc->status);
                            @endphp

                            @if ($status === 'pending')
                                <span class="status-badge status-pending"><i class="bi bi-hourglass-split"></i> Pending</span>
                            @elseif ($status === 'approved')
                                <span class="status-badge status-approved"><i class="bi bi-check-circle-fill"></i> Approved</span>
                            @elseif ($status === 'rejected')
                                <span class="status-badge status-rejected"><i class="bi bi-x-circle-fill"></i> Rejected</span>
                            @elseif ($status === 'needs revision' || $status === 'revision')
                                <span class="status-badge status-revision"><i class="bi bi-pencil-square"></i> Revision</span>
                            @endif
                        </td>

                        {{-- Action --}}
                        <td class="action-buttons">
                            <a href="{{ route('teacher.pdf.reader', $doc->document_id) }}" class="btn btn-outline-success btn-sm" title="View Document">
                                <i class="bi bi-eye-fill"></i>
                            </a>

                            <form method="POST" action="{{ route('teacher.approve', $doc->document_id) }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" title="Approve">
                                    <i class="bi bi-check-circle-fill"></i>
                                </button>
                            </form>

                            <form method="POST" action="{{ route('teacher.revise', $doc->document_id) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm" title="Mark for Revision">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </form>

                            <form method="POST" action="{{ route('teacher.reject', $doc->document_id) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" title="Reject">
                                    <i class="bi bi-x-circle-fill"></i>
                                </button>
                            </form>

                            @if(in_array($doc->status, ['Approved', 'Rejected', 'Needs Revision']))
                                <form method="POST" action="{{ route('teacher.revert', $doc->document_id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-warning btn-sm" title="Revert to Pending">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted">No studies found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $documents->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
