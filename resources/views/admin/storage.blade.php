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
        <form action="" method="GET"class="filter-form">
            <div class="filter-item">
                <input type="text" name="search" class="form-control" placeholder="🔍 Search file..." value="{{ request('search') }}">
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
    </div>


</div>

{{-- Scripts --}}
<script src="https://kit.fontawesome.com/a2e0b6f6d2.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
   const viewButtons = document.querySelectorAll('.btn-view');
    const rowsPerPage = 10;
    const table = document.querySelector('table');
    if (!table) return;

    const tbody = table.querySelector('tbody');
    const allRows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.querySelector('td'));
    const searchInput = document.querySelector('input[name="search"]');
    const filterForm = document.querySelector('.filter-form');
    const paginationList = document.getElementById('pagination');

    let filteredRows = [...allRows];
    let currentPage = 1;

    // === Pagination Functions ===
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

    // === Search Filter Function ===
    function applyFilter() {
        const searchTerm = searchInput.value.toLowerCase().trim();

        filteredRows = allRows.filter(row => {
            const title = row.cells[0]?.textContent.toLowerCase() || '';
            return title.includes(searchTerm);
        });

        // Update display
        currentPage = 1;
        if (filteredRows.length === 0) {
            tbody.innerHTML = `<tr><td="5" class="text-center text-muted">No files found</td></tr>`;
        } else {
            tbody.innerHTML = '';
            filteredRows.forEach(row => tbody.appendChild(row));
            showPage(currentPage);
            updatePagination();
        }
    }

    // === Form Submit ===
    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        applyFilter();
    });

    // === Initialize ===
    showPage(currentPage);
    updatePagination();


});
</script>



<style>

    /* === PAGE HEADER === */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-header h2 {
        font-weight: 700;
        color: #0b1b4a;
    }

    .page-header .btn {
        border-radius: 10px;
        font-weight: 600;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }
/* === FILTER CARD === */
.filter-card {
    background: #fff;
    border: none;
    border-radius: 15px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    padding: 15px;
    padding-bottom: 0.1rem !important;
}

/* === FLEX LAYOUT FOR FILTER FORM === */
.filter-form {
    display: flex;
    flex-wrap: nowrap;
    gap: 10px;
    align-items: center;
    justify-content: center;
    max-width: 700px;
    width: 100%;
}

.filter-item {
    flex: 1;
    min-width: 150px;
}

.filter-item:first-child {
    flex: 1.6;
}

.filter-item button {
    white-space: nowrap;
}

/* Responsive behavior */
@media (max-width: 576px) {
    .filter-form {
        flex-wrap: nowrap;
        overflow-x: auto;
        max-width: 100%;
    }
    .filter-item {
        min-width: 120px;
    }
}

.filter-card input,
.filter-card select {
    border-radius: 10px;
}
.table {
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.table thead th {
    background-color: #0b1b4a !important;
    color: #fff !important;
    font-weight: 700;
    font-size: 0.95rem;
    padding: 12px;
}

.table tbody td {
    padding: 12px;
    font-size: 0.93rem;
    vertical-align: middle;
}

.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #f8f8f8 !important;
}

/* Pagination Consistency */
.pagination {
    justify-content: center;
    margin-top: 10px;
}

.pagination .page-link {
    border-radius: 6px !important;
    margin: 0 3px;
    color: #0b1b4a;
    font-weight: 500;
}

.pagination .page-item.active .page-link {
    background-color: #0b1b4a;
    border-color: #0b1b4a;
    color: white;
}
.card-wrapper {
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.08);
}

    /* === ACTION BUTTONS === */
    .btn-action {
        border-radius: 8px;
        font-size: 0.9rem;
        padding: 4px 10px;
    }

    .btn-view {
        background-color: #1E90FF;
        color: #fff;
    }

    /* === MODAL STYLING === */
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    }

    .modal-body label {
        color: #0b1b4a;
    }

    .modal-footer .btn-primary {
        background-color: #0b1b4a;
        border: none;
    }

    .modal-footer .btn-primary:hover {
        background-color: #162d7d;
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }
    }
</style>



@endsection
