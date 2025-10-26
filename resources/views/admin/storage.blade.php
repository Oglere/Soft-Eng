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

            <div class="pagination-wrapper mt-3">
                <ul class="pagination justify-content-center mb-0" id="pagination"></ul>
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
   const viewButtons = document.querySelectorAll('.btn-view');

    // Load hidden rows from localStorage
    let hiddenRows = JSON.parse(localStorage.getItem('hiddenRows')) || [];

    // Apply hidden state from localStorage
    hiddenRows.forEach(index => {
        const row = document.querySelectorAll('tbody tr')[index];
        if (row) {
            const button = row.querySelector('.btn-view');
            const icon = button.querySelector('i');
            const cells = row.querySelectorAll('td:not(:last-child)');
            cells.forEach(cell => {
                if (!cell.getAttribute('data-original')) {
                    cell.setAttribute('data-original', cell.textContent.trim());
                }
                cell.textContent = '******';
            });
            button.classList.add('hidden-data');
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    });

    // Handle click events for mask/unmask
    viewButtons.forEach((button, index) => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const icon = this.querySelector('i');
            const cells = row.querySelectorAll('td:not(:last-child)');

            if (this.classList.contains('hidden-data')) {
                // Unmask
                cells.forEach(cell => {
                    const original = cell.getAttribute('data-original');
                    if (original !== null) cell.textContent = original;
                });
                this.classList.remove('hidden-data');
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');

                // Remove from localStorage
                hiddenRows = hiddenRows.filter(i => i !== index);
                localStorage.setItem('hiddenRows', JSON.stringify(hiddenRows));
            } else {
                // Mask
                cells.forEach(cell => {
                    if (!cell.getAttribute('data-original')) {
                        cell.setAttribute('data-original', cell.textContent.trim());
                    }
                    cell.textContent = '******';
                });
                this.classList.add('hidden-data');
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');

                // Save to localStorage
                if (!hiddenRows.includes(index)) {
                    hiddenRows.push(index);
                    localStorage.setItem('hiddenRows', JSON.stringify(hiddenRows));
                }
            }
        });
    });
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
        td.colSpan = 4;
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
            tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">No files found</td></tr>`;
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
