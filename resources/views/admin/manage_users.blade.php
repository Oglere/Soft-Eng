@extends('layout.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('admin/manage-users.css') }}">

@section('content')

<div class="container-fluid px-3 py-3">

    <div class="page-header">
        <h2>User Management</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-user-plus me-2"></i> Add User
        </button>
    </div>

    <div class="card filter-card mb-4">
        <form action="" method="GET" class="row g-3 align-items-center">
            <div class="col-md-5 col-sm-12">
                <input type="text" name="search" class="form-control" placeholder="🔍 Search user..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3 col-sm-6">
                <select name="filter" class="form-select">
                    <option value="">All Roles</option>
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

    <div class="card-wrapper">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>
                                @if ($user->is_active == '1')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-action btn-edit me-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editUserModal"
                                    data-id="{{ $user->user_id }}"
                                    data-first="{{ $user->first_name }}"
                                    data-last="{{ $user->last_name }}"
                                    data-email="{{ $user->email }}"
                                    data-role="{{ strtolower($user->role) }}"
                                    data-status="{{ $user->is_active == 1 ? 'Active' : 'Inactive' }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('admin.del.account', $user->user_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-action btn-delete" onclick="return confirm('Delete this user?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No users found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 shadow-lg">
        <div class="modal-header" style="background-color: #0b1b4a; color: white; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
            <h5 class="modal-title fw-semibold" id="addUserModalLabel">
            <i class="fas fa-user-plus me-2"></i>Add New User
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body text-center border-bottom pb-3">
            <button id="btnPDF" class="btn btn-outline-primary fw-semibold me-2 px-3">
            <i class="fas fa-file-upload me-1"></i> Add via PDF
            </button>
            <button id="btnManual" class="btn btn-outline-success fw-semibold px-3">
            <i class="fas fa-keyboard me-1"></i> Add Manually
            </button>
        </div>

        <form id="pdfForm" action="{{ route('admin.add.account.pdf') }}" method="POST" enctype="multipart/form-data" style="display:none;">
            @csrf
            <div class="modal-body px-4 py-4">
                <div class="row g-3">
                    <div class="mb-3">
                    <label for="fileUpload" class="form-label fw-semibold">Add User Using PDF</label>
                    <input type="file" name="fileUpload" id="fileUpload" class="form-control" accept="application/pdf" required>
                    <small class="text-danger" id="fileUploadError"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between border-0 px-4 pb-4">
                <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary rounded-3 fw-semibold px-4" style="background-color:#0b1b4a; border-color:#0b1b4a;">Save User</button>
            </div>
        </form>

        <form id="manualForm" action="{{ route('admin.add.account') }}" method="POST" style="display:none;">
            @csrf
            <div class="modal-body px-4 py-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label fw-semibold">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="form-control rounded-3" placeholder="Enter first name">
                        <div class="text-danger small mt-1 error-message" id="error-first_name" style="display:none;">First name is required.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="last_name" class="form-label fw-semibold">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="form-control rounded-3" placeholder="Enter last name">
                        <div class="text-danger small mt-1 error-message" id="error-last_name" style="display:none;">Last name is required.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="usn" class="form-label fw-semibold">USN</label>
                        <input type="number" id="usn" name="usn" class="form-control rounded-3" placeholder="Enter USN">
                        <div class="text-danger small mt-1 error-message" id="error-email" style="display:none;">USN is required.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" id="email" name="email" class="form-control rounded-3" placeholder="Enter email address">
                        <div class="text-danger small mt-1 error-message" id="error-email" style="display:none;">Email is required.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" id="password" name="password" class="form-control rounded-3" placeholder="Enter password">
                        <div class="text-danger small mt-1 error-message" id="error-password" style="display:none;">Password is required.</div>
                    </div>

                    <div class="col-md-6">
                        <label for="role" class="form-label fw-semibold">Role</label>
                        <select id="role" name="role" class="form-select rounded-3">
                            <option value="">Select role</option>
                            <option value="admin">Admin</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                        </select>
                    <div class="text-danger small mt-1 error-message" id="error-role" style="display:none;">Please select a role.</div>
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select id="status" name="is_active" class="form-select rounded-3">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>

            </div>
            <div class="modal-footer d-flex justify-content-between border-0 px-4 pb-4">
                <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary rounded-3 fw-semibold px-4" style="background-color:#0b1b4a; border-color:#0b1b4a;">Save User</button>
            </div>
        </form>
    </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
            const btnPDF = document.getElementById('btnPDF');
            const btnManual = document.getElementById('btnManual');
            const pdfForm = document.getElementById('pdfForm');
            const manualForm = document.getElementById('manualForm');

            pdfForm.style.display = 'none';
            manualForm.style.display = 'none';

            // Reset button styles
            function resetButtons() {
                btnPDF.classList.remove('btn-primary', 'text-white');
                btnManual.classList.remove('btn-success', 'text-white');
                btnPDF.classList.add('btn-outline-primary');
                btnManual.classList.add('btn-outline-success');
            }

            btnPDF.addEventListener('click', function () {
                resetButtons();
                pdfForm.style.display = 'block';
                manualForm.style.display = 'none';
                btnPDF.classList.remove('btn-outline-primary');
                btnPDF.classList.add('btn-primary', 'text-white');
            });

            btnManual.addEventListener('click', function () {
                resetButtons();
                manualForm.style.display = 'block';
                pdfForm.style.display = 'none';
                btnManual.classList.remove('btn-outline-success');
                btnManual.classList.add('btn-success', 'text-white');
            });
        });

        </script>

  </div>
</div>

{{-- Edit User Modal (Display Only) --}}
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header" style="background-color: #0b1b4a; color: white; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
        <h5 class="modal-title fw-semibold" id="editUserModalLabel">
          <i class="fas fa-user-edit me-2"></i>View User Details
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="editUserForm" action="{{ route('admin.edit.account', $user->user_id) }}" method="POST">
        @csrf
        <div class="modal-body px-4 py-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">First Name</label>
                    <input type="text" id="edit_first_name" name="first_name" class="form-control rounded-3" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Last Name</label>
                    <input type="text" id="edit_last_name" name="last_name" class="form-control rounded-3" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" id="edit_email" name="email" class="form-control rounded-3" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Role</label>
                    <select id="edit_role" name="role" class="form-select rounded-3">
                        <option value="admin">Admin</option>
                        <option value="teacher">Teacher</option>
                        <option value="student">Student</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Status</label>
                    <select id="edit_status" name="is_active" class="form-select rounded-3">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="col-md-6" style="display: flex; padding-top: 29px; justify-content: flex-end">
                    <button type="submit" class="btn btn-primary rounded-3 fw-semibold px-4" style="background-color:#0b1b4a; border-color:#0b1b4a;">Update</button>
                </div>
            </div>
        </div>
      </form>

      <div class="modal-footer border-0 px-4 pb-4 d-flex justify-content-end">
        <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://kit.fontawesome.com/a2e0b6f6d2.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Validation for Add Modal
  document.getElementById('addUserForm').addEventListener('submit', function(e) {
      e.preventDefault();
      document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');
      let hasError = false;
      const fields = ['first_name', 'last_name', 'email', 'password', 'role'];
      fields.forEach(field => {
          const value = document.getElementById(field).value.trim();
          if (!value) {
              document.getElementById('error-' + field).style.display = 'block';
              hasError = true;
          }
      });
      if (!hasError) alert('Form submitted successfully! (for testing only)');
  });

  // Populate Edit Modal (Display Only)
  const editButtons = document.querySelectorAll('.btn-edit');
  editButtons.forEach(button => {
    button.addEventListener('click', function() {
      document.getElementById('edit_first_name').value = this.dataset.first;
      document.getElementById('edit_last_name').value = this.dataset.last;
      document.getElementById('edit_email').value = this.dataset.email;
      document.getElementById('edit_role').value = this.dataset.role;
      document.getElementById('edit_status').value = this.dataset.status;
    });
  });

</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.btn-edit');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Get user data from button attributes
            const userId = this.dataset.id;
            const first = this.dataset.first;
            const last = this.dataset.last;
            const email = this.dataset.email;
            const role = this.dataset.role.toLowerCase();
            const status = this.dataset.status === 'Active' ? '1' : '0';

            // Fill modal fields
            document.getElementById('edit_first_name').value = first;
            document.getElementById('edit_last_name').value = last;
            document.getElementById('edit_email').value = email;

            // Set dropdowns dynamically
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_status').value = status;

            // Dynamically set form action
            const form = document.getElementById('editUserForm');
            form.action = `/admin/edit-account/${userId}`;
        });
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    // === PAGINATION WITH 10 ROW DISPLAY (same as Storage) ===
    const rowsPerPage = 10;
    const table = document.querySelector('table');
    const tbody = table.querySelector('tbody');
    let rows = Array.from(tbody.querySelectorAll('tr'));
    const totalPages = Math.ceil(rows.length / rowsPerPage) || 1;
    let currentPage = 1;

    // Create pagination container
    const paginationContainer = document.createElement('nav');
    paginationContainer.classList.add('mt-3');
    const paginationList = document.createElement('ul');
    paginationList.classList.add('pagination', 'justify-content-center');
    paginationContainer.appendChild(paginationList);
    table.parentElement.appendChild(paginationContainer);

    // Function to create blank placeholder rows
    function createEmptyRow() {
        const tr = document.createElement('tr');
        const td = document.createElement('td');
        td.colSpan = 6; // Adjust based on number of columns in your table
        td.innerHTML = "&nbsp;"; // Keeps consistent height
        tr.appendChild(td);
        return tr;
    }

    // Function to display the correct rows per page
    function showPage(page) {
        // Hide all rows
        rows.forEach(row => row.style.display = 'none');

        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const visibleRows = rows.slice(start, end);

        // Remove old filler rows
        tbody.querySelectorAll('.empty-row').forEach(r => r.remove());

        // Show the current set of rows
        visibleRows.forEach(row => row.style.display = '');

        // Add filler rows if fewer than 10
        const missingRows = rowsPerPage - visibleRows.length;
        for (let i = 0; i < missingRows; i++) {
            const emptyRow = createEmptyRow();
            emptyRow.classList.add('empty-row');
            tbody.appendChild(emptyRow);
        }
    }

    // Function to update pagination buttons
    function updatePagination() {
        paginationList.innerHTML = '';

        // Previous button
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

        // Next button
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

    // Initialize pagination
    showPage(currentPage);
    updatePagination();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.btn-edit');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Get user data from button attributes
            const userId = this.dataset.id;
            const first = this.dataset.first;
            const last = this.dataset.last;
            const email = this.dataset.email;
            const role = this.dataset.role;
            const status = this.dataset.status;

            // Fill modal fields
            document.getElementById('edit_first_name').value = first;
            document.getElementById('edit_last_name').value = last;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_status').value = status;

            // Dynamically set form action
            const form = document.getElementById('editUserForm');
            form.action = `/admin/edit-account/${userId}`;
        });
    });
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
    .btn-action {
        border-radius: 8px;
        font-size: 0.9rem;
        padding: 4px 10px;
    }

    .btn-edit {
        background-color: #2E8B57;
        color: #fff;
    }

    .btn-delete {
        background-color: #B22222;
        color: #fff;
    }

    .btn-edit:hover, .btn-delete:hover {
        opacity: 0.9;
    }

    .card-wrapper {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        padding: 25px;
    }

    /* === MODAL STYLING === */
    .modal-content {
        border-radius: 15px;
        border: none;
    }

    .modal-header {
        border-bottom: none;
    }

    .form-label {
        font-size: 0.9rem;
        color: #0b1b4a;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #ccc;
        box-shadow: none;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0b1b4a;
        box-shadow: 0 0 0 0.2rem rgba(11, 27, 74, 0.15);
    }

    .error-message {
        font-size: 0.85rem;
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('manualForm');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        // Remove previous error messages
        document.querySelectorAll('.error-text').forEach(el => el.remove());
        let isValid = true;

        function showError(input, message) {
            const error = document.createElement('div');
            error.className = 'error-text';
            error.textContent = message;
            error.style.color = '#e74c3c';
            error.style.fontSize = '0.85rem';
            error.style.marginTop = '6px';
            input.insertAdjacentElement('afterend', error);
        }

        // Fields
        const first = document.getElementById('first_name');
        const last = document.getElementById('last_name');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const role = document.getElementById('role');
        const status = document.getElementById('status');

        // Validation
        if (first.value.trim() === '') { showError(first, 'First name is required.'); isValid = false; }
        if (last.value.trim() === '') { showError(last, 'Last name is required.'); isValid = false; }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email.value.trim() === '') {
            showError(email, 'Email is required.');
            isValid = false;
        } else if (!emailPattern.test(email.value.trim())) {
            showError(email, 'Please enter a valid email.');
            isValid = false;
        }

        if (password.value.trim() === '') {
            showError(password, 'Password is required.');
            isValid = false;
        } else if (password.value.trim().length < 6) {
            showError(password, 'Password must be at least 6 characters.');
            isValid = false;
        }

        if (role.value === '') {
            showError(role, 'Please select a role.');
            isValid = false;
        }

        if (status.value === '') {
            showError(status, 'Please select a status.');
            isValid = false;
        }

        // Stop here if invalid
        if (!isValid) {
            Swal.fire({
                icon: 'error',
                title: 'Form Error',
                text: 'Please correct the highlighted fields before submitting.',
                confirmButtonColor: '#e74c3c'
            });
            return;
        }

        // --- Check for duplicate email ---
        try {
            const response = await fetch("{{ route('admin.checkEmail') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ email: email.value.trim() })
            });

            const data = await response.json();

            if (data.exists) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Duplicate Email',
                    text: 'This email is already registered. Please use another one.'
                });
                return;
            }

            // All good — submit the form
            form.submit();

        } catch (error) {
            console.error('Error checking email:', error);
            Swal.fire('Error', 'An unexpected error occurred. Please try again.', 'error');
        }
    });

    // --- SweetAlert messages after redirect ---
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2500
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#e74c3c'
        });
    @endif

});
</script>
