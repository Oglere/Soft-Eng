@extends('layout.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin/storage.css') }}">

@section('content')
<div class="container-fluid px-3 py-3">

    {{-- Header --}}
    <div class="page-header">
        <h2>Storage Management</h2>
    </div>

    {{-- Search & Filter --}}
    <div class="card filter-card mb-4">
        <form action="" method="GET" class="filter-form">
            <div class="filter-item">
                <input type="text" name="search" class="form-control" placeholder="🔍 Search file..." value="{{ request('search') }}">
            </div>
            <div class="col-md-6" style="width: 25%">
                <select id="role" name="role" class="form-select rounded-3">
                    <option value="">All documents</option>
                    <option value="admin">Hide</option>
                    <option value="student">Unhide</option>
                </select>
                <div class="text-danger small mt-1 error-message" id="error-role" style="display:none;">Please select a role.</div>
            </div>

            <div class="filter-item">
                <button type="submit" class="btn btn-dark w-100">Filter</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card-wrapper">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>File Size</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($documents as $doc)
                        <tr>
                            <td>{{ $doc->title }}</td>
                            <td>
                                @if ($doc->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Archived</span>
                                @endif
                            </td>
                            <td>{{ $doc->created_at->format('M d, Y') }}</td>
                            <td>
                                @php
                                    $bytes = strlen($doc->file);
                                    if ($bytes >= 1073741824) {
                                        $size = number_format($bytes / 1073741824, 2) . ' GB';
                                    } elseif ($bytes >= 1048576) {
                                        $size = number_format($bytes / 1048576, 2) . ' MB';
                                    } elseif ($bytes >= 1024) {
                                        $size = number_format($bytes / 1024, 2) . ' KB';
                                    } else {
                                        $size = $bytes . ' Bytes';
                                    }
                                @endphp
                                {{ $size }}
                            </td>

                            <td class="text-center">
                                <form action="storage/hide/{{ $doc->document_id }}" method="POST" style="margin: 0;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-action btn-view me-1">
                                        @if ($doc->archived == '1')
                                            <i class="fas fa-eye-slash"></i>
                                        @else
                                            <i class="fas fa-eye"></i>
                                        @endif
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No documents found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Pagination container --}}
        <ul class="pagination" id="pagination"></ul>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://kit.fontawesome.com/a2e0b6f6d2.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

{{-- Hide/Unhide Confirmation --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const viewButtons = document.querySelectorAll('.btn-view');

    viewButtons.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const form = this.closest('form');
            const isHidden = this.classList.contains('hidden-doc');

            Swal.fire({
                title: isHidden ? 'Unhide Document?' : 'Hide Document?',
                text: isHidden 
                    ? "This document will be visible again in storage." 
                    : "Are you sure you want to hide this document from storage?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: isHidden ? 'Yes, Unhide it!' : 'Yes, Hide it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Set button color dynamically
    document.querySelectorAll('.btn-view').forEach(button => {
        if (button.querySelector('i').classList.contains('fa-eye-slash')) {
            button.classList.add('hidden-doc');
            button.style.backgroundColor = 'red';
        } else {
            button.classList.remove('hidden-doc');
            button.style.backgroundColor = '#1E90FF';
        }
    });
});
</script>

{{-- Search + Filter + Pagination --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const rowsPerPage = 10;
    const table = document.querySelector('table');
    if (!table) return;

    const tbody = table.querySelector('tbody');
    const allRows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.querySelector('td'));
    const searchInput = document.querySelector('input[name="search"]');
    const roleSelect = document.querySelector('select[name="role"]');
    const filterForm = document.querySelector('.filter-form');
    const paginationList = document.getElementById('pagination');

    let filteredRows = [...allRows];
    let currentPage = 1;

    // === Pagination ===
    function createEmptyRow() {
        const tr = document.createElement('tr');
        const td = document.createElement('td');
        td.colSpan = 5;
        td.innerHTML = "&nbsp;";
        tr.classList.add('empty-row');
        tr.appendChild(td);
        return tr;
    }

    function showPage(page) {
        filteredRows.forEach(row => row.style.display = 'none');
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const visibleRows = filteredRows.slice(start, end);

        tbody.querySelectorAll('.empty-row').forEach(e => e.remove());
        visibleRows.forEach(row => row.style.display = '');

        const missingRows = rowsPerPage - visibleRows.length;
        for (let i = 0; i < missingRows; i++) {
            tbody.appendChild(createEmptyRow());
        }
    }

    function updatePagination() {
        paginationList.innerHTML = '';
        const totalPages = Math.ceil(filteredRows.length / rowsPerPage) || 1;

        const prevItem = document.createElement('li');
        prevItem.classList.add('page-item', currentPage === 1 ? 'disabled' : '');
        prevItem.innerHTML = `<a class="page-link" href="#">Previous</a>`;
        prevItem.addEventListener('click', e => {
            e.preventDefault();
            if (currentPage > 1) {
                currentPage--;
                showPage(currentPage);
                updatePagination();
            }
        });
        paginationList.appendChild(prevItem);

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.classList.add('page-item', i === currentPage ? 'active' : '');
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.addEventListener('click', e => {
                e.preventDefault();
                currentPage = i;
                showPage(currentPage);
                updatePagination();
            });
            paginationList.appendChild(li);
        }

        const nextItem = document.createElement('li');
        nextItem.classList.add('page-item', currentPage === totalPages ? 'disabled' : '');
        nextItem.innerHTML = `<a class="page-link" href="#">Next</a>`;
        nextItem.addEventListener('click', e => {
            e.preventDefault();
            if (currentPage < totalPages) {
                currentPage++;
                showPage(currentPage);
                updatePagination();
            }
        });
        paginationList.appendChild(nextItem);
    }

    // === Filter Function ===
    function applyFilter() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const filterValue = roleSelect.value;

        filteredRows = allRows.filter(row => {
            const title = row.cells[0]?.textContent.toLowerCase() || '';
            const isHidden = row.querySelector('i.fa-eye-slash');
            const matchesSearch = title.includes(searchTerm);

            if (filterValue === 'admin') {
                return matchesSearch && isHidden;
            } else if (filterValue === 'student') {
                return matchesSearch && !isHidden;
            } else {
                return matchesSearch;
            }
        });

        tbody.innerHTML = '';
        if (filteredRows.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center text-muted">No documents found</td></tr>`;
        } else {
            filteredRows.forEach(row => tbody.appendChild(row));
            showPage(currentPage);
            updatePagination();
        }
    }

    // === On Filter Submit ===
    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        currentPage = 1;
        applyFilter();
    });

    // === Initialize ===
    showPage(currentPage);
    updatePagination();
});
</script>
@endsection
