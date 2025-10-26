@extends('layout.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('admin/manage-users.css') }}">
<link rel="stylesheet" href="{{ asset('admin/manage-users-2.css') }}">

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
        <!-- Toggle Buttons -->
        <div class="mb-3">
            <button class="btn btn-primary btn-sm me-2" id="btnUsers">Users</button>
            <button class="btn btn-outline-secondary btn-sm" id="btnDeleted">Deleted Users</button>
        </div>

        <!-- Active Users Table -->
        <div id="usersTable" class="table-responsive">
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
                                <!-- Edit Button -->
                                <button class="btn btn-sm btn-action btn-edit me-1"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editUserModal"
                                        data-id="{{ $user->user_id }}"
                                        data-first="{{ $user->first_name }}"
                                        data-usn="{{ $user->usn }}"
                                        data-last="{{ $user->last_name }}"
                                        data-email="{{ $user->email }}"
                                        data-role="{{ strtolower($user->role) }}"
                                        data-status="{{ $user->is_active }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Delete Button -->
                                <button type="button" class="btn btn-sm btn-action btn-delete"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteUserModal"
                                        data-id="{{ $user->user_id }}"
                                        data-name="{{ $user->first_name }} {{ $user->last_name }}">
                                    <i class="fas fa-trash"></i>
                                </button>
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

        <!-- Deleted Users Table -->
        <div id="deletedTable" class="table-responsive mt-4" style="display:none;">
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
                    @forelse ($toRecover as $user)
                        <tr>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>
                                <span class="badge bg-warning">Deleted</span>
                            </td>
                            <td class="text-center">
                                <!-- Edit Button -->

                                <button type="button" class="btn btn-sm btn-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#recoverUserModal"
                                        data-id="{{ $user->user_id }}"
                                        data-name="{{ $user->first_name }} {{ $user->last_name }}">
                                    <i class="fas fa-undo"></i>
                                </button>
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
            <i class="fas fa-file-upload me-1"></i> Add via Excel
            </button>
            <button id="btnManual" class="btn btn-outline-success fw-semibold px-3">
            <i class="fas fa-keyboard me-1"></i> Add Manually
            </button>
        </div>

        <form id="pdfForm" action="{{ route('admin.add.acc.excel') }}" method="POST" enctype="multipart/form-data" style="display:none;">
            @csrf
            <div class="modal-body px-4 py-4">
                <div class="row g-3">
                    <div class="mb-3">
                        <label for="fileUpload" class="form-label fw-semibold">Upload Excel File</label>
                        <input type="file" name="fileUpload" id="fileUpload" class="form-control" accept=".xlsx,.xls" required>
                        <small class="text-muted">Only Excel files (.xlsx, .xls) are allowed.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between border-0 px-4 pb-4">
                <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary rounded-3 fw-semibold px-4" style="background-color:#0b1b4a; border-color:#0b1b4a;">Upload</button>
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
                <button type="submit" class="btn btn-primary rounded-3 fw-semibold px-4" style="background-color:#0b1b4a; border-color:#0b1b4a;">Add User</button>
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

      <form id="editUserForm" action="" method="POST">
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
                    <label class="form-label fw-semibold">USN</label>
                    <input type="text" id="edit_usn" name="usn" class="form-control rounded-3" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Password (Leave Blank to Remain Changes)</label>
                    <input type="password" id="edit_password" name="password_hash" class="form-control rounded-3" placeholder="Password">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" id="edit_email" name="email" class="form-control rounded-3" placeholder="Email">
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

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header" style="background-color: #0b1b4a; color: white; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                <h5 class="modal-title fw-semibold" id="deleteUserModalLabel">
                    <i class="fas fa-user-minus me-2"></i>Delete User
                    <span id="deleteUserName"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="deleteForm" action="" method="POST">
                @csrf
                <input type="hidden" name="user_id" id="delete_user_id">
                <div class="modal-body px-4 py-4">
                    <p class="fw-semibold">Are you sure you want to delete <span id="deleteUserNameBody"></span>?</p>
                </div>
                <div class="modal-footer d-flex justify-content-between border-0 px-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger rounded-3 fw-semibold px-4">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Recover User Modal -->
<div class="modal fade" id="recoverUserModal" tabindex="-1" aria-labelledby="recoverUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header" style="background-color: #0b1b4a; color: white; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                <h5 class="modal-title fw-semibold" id="recoverUserModalLabel">
                    <i class="fas fa-undo me-2"></i>Recover User
                    <span id="recoverUserNameHeader"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="recoverForm" action="" method="POST">
                @csrf
                <input type="hidden" name="user_id" id="recover_user_id">
                <div class="modal-body px-4 py-4">
                    <p class="fw-semibold">
                        Are you sure you want to recover <span id="recoverUserNameBody"></span>?
                    </p>
                </div>
                <div class="modal-footer d-flex justify-content-between border-0 px-4 pb-4">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success rounded-3 fw-semibold px-4">
                        Yes, Recover
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<script src="https://kit.fontawesome.com/a2e0b6f6d2.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('js/admin/1.js') }}"></script>
<script src="{{ asset('js/admin/2.js') }}"></script>
<script src="{{ asset('js/admin/3.js') }}"></script>
<script src="{{ asset('js/admin/4.js') }}"></script>
<script src="{{ asset('js/admin/5.js') }}"></script>
<script src="{{ asset('js/admin/6.js') }}"></script>

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
        const usn = document.getElementById('usn');
        const first = document.getElementById('first_name');
        const last = document.getElementById('last_name');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const role = document.getElementById('role');
        const status = document.getElementById('status');

        // Validation
        if (usn.value.trim() === '') {
            showError(usn, 'USN is required.');
            isValid = false;
        }

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

        // --- Check for duplicate USN and Email ---
        try {
            const response = await fetch("{{ route('admin.checkDuplicates') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    email: email.value.trim(),
                    usn: usn.value.trim()
                })
            });

            const data = await response.json();

            if (data.email_exists) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Duplicate Email',
                    text: 'This email is already registered. Please use another one.'
                });
                return;
            }

            if (data.usn_exists) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Duplicate USN',
                    text: 'This USN already exists. Please use another one.'
                });
                return;
            }

            // All good — submit the form
            form.submit();

        } catch (error) {
            console.error('Error checking duplicates:', error);
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
<script>
document.addEventListener('DOMContentLoaded', () => {
    const editForm = document.getElementById('editUserForm');

    if (editForm) {
        editForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            // Clear old errors
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
            const first = document.getElementById('edit_first_name');
            const last = document.getElementById('edit_last_name');
            const usn = document.getElementById('edit_usn');
            const email = document.getElementById('edit_email');
            const password = document.getElementById('edit_password');
            const role = document.getElementById('edit_role');
            const status = document.getElementById('edit_status');
            const currentEmail = email.getAttribute('data-original-email'); // store original email

            // Validation
            if (first.value.trim() === '') { showError(first, 'First name is required.'); isValid = false; }
            if (last.value.trim() === '') { showError(last, 'Last name is required.'); isValid = false; }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email.value.trim() === '') {
                showError(email, 'Email is required.');
                isValid = false;
            } else if (!emailPattern.test(email.value.trim())) {
                showError(email, 'Please enter a valid email address.');
                isValid = false;
            }

            if (password.value.trim() !== '' && password.value.trim().length < 6) {
                showError(password, 'Password must be at least 6 characters.');
                isValid = false;
            }

            if (role.value === '') { showError(role, 'Please select a role.'); isValid = false; }
            if (status.value === '') { showError(status, 'Please select a status.'); isValid = false; }

            if (!isValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Form Error',
                    text: 'Please correct the highlighted fields before submitting.',
                    confirmButtonColor: '#e74c3c'
                });
                return;
            }

            editForm.submit();
        });
    }

    // --- SweetAlert after redirect ---
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

    @if(session('info'))
        Swal.fire({
            icon: 'info',
            title: 'Notice',
            text: "{{ session('info') }}",
            confirmButtonColor: '#3085d6'
        });
    @endif
});
</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const recoverForm = document.getElementById('recoverForm');

    if (recoverForm) {
        recoverForm.addEventListener('submit', function(e) {
            e.preventDefault(); // prevent default to optionally add confirmation

            // Optional: extra confirmation before submitting
            recoverForm.submit();
        });
    }

    // SweetAlert after redirect
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Recovered!',
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
