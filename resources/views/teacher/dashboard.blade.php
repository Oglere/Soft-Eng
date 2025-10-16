@extends('layout.teacher')

@section('right')
<style>
/* Match Student Dashboard Design */

.right h1 {
    font-size: 40px;
    font-weight: bold;
    color: #0e100f;
}

.cardco {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 25px;
    margin-top: 40px;
}

.cards {
    border-radius: 20px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    width: 230px;
    text-align: center;
    padding: 25px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.cards:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.cards img {
    width: 100px;
    height: 100px;
    margin-bottom: 10px;
}

.count {
    font-size: 38px;
    font-weight: bold;
    color: #0e100f;
}

.text p {
    font-size: 16px;
    font-weight: 500;
    color: #555;
    margin-top: 5px;
}
</style>

<h1>
    Welcome, {{ $user->first_name }}! You have
</h1>

<div class="cardco">

    {{-- Pending --}}
    <div class="cards pending">
        <div class="svg1">
            <img src="{{ asset('images/book.png') }}" alt="Pending">
        </div>
        <div class="count">{{ $pending }}</div>
        <div class="text">
            <p>STUDIES TO REVIEW</p>
        </div>
    </div>

    {{-- Approved --}}
    <div class="cards approved">
        <div class="svg2">
            <img src="{{ asset('images/approved.png') }}" alt="Approved">
        </div>
        <div class="count">{{ $approved }}</div>
        <div class="text">
            <p>APPROVED STUDIES</p>
        </div>
    </div>

    {{-- Rejected --}}
    <div class="cards rejected">
        <div class="svg3">
            <img src="{{ asset('images/reject.png') }}" alt="Rejected">
        </div>
        <div class="count">{{ $rejected }}</div>
        <div class="text">
            <p>REJECTED STUDIES</p>
        </div>
    </div>

</div>
@endsection
