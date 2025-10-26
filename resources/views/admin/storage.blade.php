@extends('layout.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin/storage.css') }}">

@section('content')
<div class="container-fluid px-3 py-3">

    {{-- Header --}}
    <div class="page-header">
        <h2>Storage Management</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFileModal">
            <i class="fas fa-upload me-2"></i> Add File
        </button>
    </div>

    {{-- Search & Filter --}}
    <div class="card filter-card mb-4">
        <form action="" method="GET" class="row g-3 align-items-center">
            <div class="col-md-5 col-sm-12">
                <input type="text" name="search" class="form-control" placeholder="🔍 Search file..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3 col-sm-6">
                <select name="filter" class="form-select">
                    <option value="">All</option>
                    <option value="1">Admin</option>
                    <option value="2">Student</option>
                    <option value="3">Teacher</option>
                </select>
            </div>
            <div class="col-md-2 col-sm-6">
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
                        <th>File Size</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>System_Report_2025.pdf</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td>2.4 MB</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-action btn-view me-1"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Research_Data_2024.xlsx</td>
                        <td><span class="badge bg-secondary">Archived</span></td>
                        <td>1.8 MB</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-action btn-view me-1"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Add File Modal --}}
<div class="modal fade" id="addFileModal" tabindex="-1" aria-labelledby="addFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0b1b4a; color: #fff;">
                <h5 class="modal-title fw-bold" id="addFileModalLabel">
                    <i class="fas fa-upload me-2"></i> Add New File
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fileTitle" class="form-label fw-semibold">File Title</label>
                        <input type="text" name="fileTitle" id="fileTitle" class="form-control" placeholder="Enter file title" required>
                        <small class="text-danger" id="fileTitleError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="fileUpload" class="form-label fw-semibold">Upload File</label>
                        <input type="file" name="fileUpload" id="fileUpload" class="form-control" required>
                        <small class="text-danger" id="fileUploadError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="fileStatus" class="form-label fw-semibold">Status</label>
                        <select name="fileStatus" id="fileStatus" class="form-select" required>
                            <option value="">-- Select Status --</option>
                            <option value="active">Active</option>
                            <option value="archived">Archived</option>
                        </select>
                        <small class="text-danger" id="fileStatusError"></small>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fw-semibold">Upload File</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://kit.fontawesome.com/a2e0b6f6d2.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // === Eye Button Mask/Unmask ===
    const viewButtons = document.querySelectorAll('.btn-view');

    viewButtons.forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const icon = this.querySelector('i');
            const cells = row.querySelectorAll('td:not(:last-child)');

            if (this.classList.contains('hidden-data')) {
                cells.forEach(cell => {
                    const original = cell.getAttribute('data-original');
                    if (original !== null) cell.textContent = original;
                });
                this.classList.remove('hidden-data');
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                cells.forEach(cell => {
                    if (!cell.getAttribute('data-original')) {
                        cell.setAttribute('data-original', cell.textContent.trim());
                    }
                    cell.textContent = '******';
                });
                this.classList.add('hidden-data');
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    });

    // === PAGINATION INSIDE TABLE (SHOW 10 ROWS) ===
    const rowsPerPage = 10;
    const table = document.querySelector('table');
    const tbody = table.querySelector('tbody');
    let rows = Array.from(tbody.querySelectorAll('tr'));
    const totalPages = Math.ceil(rows.length / rowsPerPage) || 1;
    let currentPage = 1;

    // Create a <tfoot> if not existing
    let tfoot = table.querySelector('tfoot');
    if (!tfoot) {
        tfoot = document.createElement('tfoot');
        table.appendChild(tfoot);
    }

    // Create pagination row
    const paginationRow = document.createElement('tr');
    const paginationCell = document.createElement('td');
    paginationCell.colSpan = 4;
    paginationCell.classList.add('text-center');
    paginationRow.appendChild(paginationCell);
    tfoot.appendChild(paginationRow);

    // Create pagination container
    const paginationList = document.createElement('ul');
    paginationList.classList.add('pagination', 'justify-content-center', 'mb-0');
    paginationCell.appendChild(paginationList);

    function createEmptyRow() {
        const tr = document.createElement('tr');
        const td = document.createElement('td');
        td.colSpan = 4;
        td.innerHTML = "&nbsp;";
        tr.classList.add('empty-row');
        tr.appendChild(td);
        return tr;
    }

    function showPage(page) {
        rows.forEach(row => row.style.display = 'none');

        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const visibleRows = rows.slice(start, end);

        // Remove filler rows
        tbody.querySelectorAll('.empty-row').forEach(e => e.remove());

        // Show visible rows
        visibleRows.forEach(row => row.style.display = '');

        // Add filler rows if needed
        const missingRows = rowsPerPage - visibleRows.length;
        for (let i = 0; i < missingRows; i++) {
            tbody.appendChild(createEmptyRow());
        }
    }

    function updatePagination() {
        paginationList.innerHTML = '';

        // Prev
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

        // Page numbers
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

        // Next
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

    // Initialize
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
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        padding: 20px;
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
