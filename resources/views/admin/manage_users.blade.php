@extends('layout.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin/manage_user.css') }}">

@section('content')



<div class="container-fluid px-3 py-3">

    {{-- Header --}}
    <div class="page-header">
        <h2>User Management</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-user-plus me-2"></i> Add User
        </button>
    </div>

    {{-- Search & Filter --}}
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

    {{-- Table --}}
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
                    <tr>
                        <td>John</td>
                        <td>Doe</td>
                        <td>john@example.com</td>
                        <td>Admin</td>
                        <td><span class="badge bg-success">Active</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-action btn-edit me-1"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-action btn-delete"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Jane</td>
                        <td>Smith</td>
                        <td>jane@example.com</td>
                        <td>Student</td>
                        <td><span class="badge bg-secondary">Inactive</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-action btn-edit me-1"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-action btn-delete"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://kit.fontawesome.com/a2e0b6f6d2.js" crossorigin="anonymous"></script>

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

    /* === TABLE DESIGN (same as dashboard) === */
    .table {
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
    }

    .table thead.table-dark th {
        background: #0b1b4a !important;
        color: #fff;
        border: none;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
    }

    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #fff9dc !important;
    }

    .table-striped > tbody > tr:nth-of-type(even) {
        background-color: #fffbea !important;
    }

    .table-hover tbody tr:hover {
        background-color: #fdf3c5 !important;
        transition: 0.2s ease;
    }

    .table td, .table th {
        vertical-align: middle;
    }

    /* === ACTION BUTTONS === */
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

    /* === CARD WRAPPER === */
    .card-wrapper {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
        padding: 25px;
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
