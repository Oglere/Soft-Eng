@extends('layout.admin')
{{-- <link rel="stylesheet" href="{{ asset('') }}"> --}}
@section('title', 'Dashboard')

@section('content')

    Admin Dashboard

<div class="row g-3">
    <div class="col-md-4" >
        <div class="card shadow-sm p-3" id="card-1">
            <h2 class="mb-1">21</h2>
            <p>Total Users</p>
            <div class="text-end">
                <a href="#" class="btn btn-sm w-100" id="card1">More info</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm p-3" id="card-2">
            <h2 class="mb-1">34</h2>
            <p>Total Admins</p>
            <div class="text-end">
                <a href="#" class="btn btn-sm w-100" id="card2">More info</a>
            </div>
        </div>
    </div>

    <div class="col-md-4"> <!-- ✅ third card must also be col-md-4 -->
        <div class="card shadow-sm p-3" id="card-3">
            <h2 class="mb-1">50</h2>
            <p>Total Storage</p>
            <div class="text-end">
                <a href="#" class="btn btn-sm w-100" id="card3">More info</a>
            </div>
        </div>
    </div>
</div>

{{-- Next row --}}
<div class="row g-3 mt-0">
    <div class="col-md-8">
        <div class="card shadow-sm p-3 h-100">
            
            <canvas id="chart1" class="chart"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm p-3 h-100">
            
            <canvas id="chart2" class="chart2"></canvas>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12" id="dashtable">
        <table class="table table-bordered table-striped" >
            <thead class="table-dark">
               <p> Recent Users Online </p>
                <tr>
                    <th style="width: 60%">Name</th>
                    <th>Last online</th>
            </thead>
            <tbody>
                <tr>
                    <td>asdsd</td>
                    <td>asd</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>c

@endsection

{{-- <script src="{{ asset('') }}"></script> --}}
