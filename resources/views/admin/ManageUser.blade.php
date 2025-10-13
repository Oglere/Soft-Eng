@extends('layouts.admin')

@section('title', 'Manage User')

@section('content')

<div class="row mt-4 d-flex justify-content-between align-items-center">
    <div class="col-md-6">
        <form action="" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="{{ request('search') }}">
            <select name="filter" class="form-select me-2" style="max-width: 150px;">
                <option value="">All</option>
                <option value="1">Option 1</option>
                <option value="2">Option 2</option>
                <option value="3">Option 3</option>
            </select>
            <button type="submit" class="btn btn-outline-primary">Search</button>
        </form>
    </div>
        <div class="col-md-2 text-end" id="addbutton" >
            <a href="{{ route('manageuser.create') }}"class="btn " id="MUBTN" >Add</a>
        </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>asdw</td>
                    <td>dasd</td>
                    <td>fasd</td>
                    <td>fasx</td>
                    <td>gasxsa</td>
                    <td>asdds</td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
@endsection
