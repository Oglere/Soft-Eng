@extends('layout.admin')
{{-- <link rel="stylesheet" href="{{ asset('') }}"> --}}

@section('right')

    Admin Storage

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
    <!-- <div class="col-md-2 text-end">
        <a href="" class="btn btn-primary">Add</a>
    </div> -->
</div>

<div class="row mt-4">
    <div class="col-12">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width: 50%;">Title</th>
                    <th>Status</th>
                    <th>File Size</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

{{-- <script src="{{ asset('') }}"></script> --}}
