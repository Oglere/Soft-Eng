@extends('layout.header')

@section('content')
<div class="container">
    <h2>Reset Password</h2>
    <form method="POST" action="{{ route('password.reset') }}">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') }}">
        <input type="password" name="password" placeholder="New Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        @error('password') <p class="error">{{ $message }}</p> @enderror
        <button type="submit">Reset Password</button>
    </form>
</div>
@endsection
