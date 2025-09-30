@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card p-4 shadow-sm">
                <h3>Add New User</h3>
                <form action="{{ route('manageuser.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add User</button>
                    <a href="{{ route('manageuser.index') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
@endsection
