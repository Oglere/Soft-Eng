@extends('layout.teacher')

@section('right')
<style>
    /* Teacher Dashboard Styles */

.teacher-dashboard {
    text-align: center;
    padding: 40px 20px;
    font-family: 'Poppins', sans-serif;
}

.welcome-message {
    color: #030281;
    font-weight: 700;
    margin-bottom: 40px;
}

.stats-overview {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 60px;
    flex-wrap: wrap;
    margin-bottom: 50px;
}

.stat-box {
    text-align: center;
    background: #ffffff;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    width: 180px;
}

.stat-box:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
}

.stat-box img {
    width: 60px;
    height: 60px;
    margin-bottom: 10px;
}

.stat-box .count {
    display: block;
    font-size: 28px;
    font-weight: bold;
    color: #030281;
    margin-bottom: 5px;
}

.stat-box p {
    margin: 0;
    font-size: 15px;
    color: #555;
}

</style>


<div class="teacher-dashboard">
    {{-- Welcome Message --}}
    <h2 class="welcome-message">
        Welcome, {{ $user->first_name }}! You Have
    </h2>

    {{-- Stats Overview --}}
    <div class="stats-overview">
        {{-- Pending --}}
        <div class="stat-box">
            <img src="{{ asset('storage/images/book.png') }}" alt="Pending">
            <span class="count">{{ $pending }}</span>
            <p>Studies to Review</p>
        </div>

        {{-- Approved --}}
        <div class="stat-box">
            <img src="{{ asset('storage/images/approved.png') }}" alt="Approved">
            <span class="count">{{ $approved }}</span>
            <p>Approved Studies</p>
        </div>

        {{-- Rejected --}}
        <div class="stat-box">
            <img src="{{ asset('storage/images/reject.png') }}" alt="Rejected">
            <span class="count">{{ $rejected }}</span>
            <p>Rejected Studies</p>
        </div>
    </div>

</div>
@endsection
