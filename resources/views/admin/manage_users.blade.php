@extends('layout.admin')

@section('title', 'Manage Users')

@section('right')
    User Control
    <div class="row mt-4 d-flex justify-content-between align-items-center">
    <div class="col-md-6">
        <form action="" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="{{ request('search') }}">
            <select name="filter" class="form-select me-2" style="max-width: 150px;">
                <option value="">All</option>
                <option value="1">Admin</option>
                <option value="2">Student</option>
                <option value="3">Teacher</option>
            </select>
            <button type="submit" class="btn btn-outline-primary">Search</button>
        </form>
    </div>
    <div class="col-md-2 text-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
        Add
        </button>

    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email </th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                    <td>6</td>
                </tr>
            </tbody>
        </table>

    </div>
</div>


@include('admin.manage_users_crud.add_manage_users')


@endsection



