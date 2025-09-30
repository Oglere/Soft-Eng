@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h2 class="mb-1">21</h2>
            <p>Total Users</p>
            <div class="text-end">
                <a href="#" class="btn btn-sm btn-primary w-100">More info</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h2 class="mb-1">34</h2>
            <p>Total Admins</p>
            <div class="text-end">
                <a href="#" class="btn btn-sm btn-primary w-100">More info</a>
            </div>
        </div>
    </div>

    <div class="col-md-4"> <!-- ✅ third card must also be col-md-4 -->
        <div class="card shadow-sm p-3">
            <h2 class="mb-1">50</h2>
            <p>Total Storage</p>
            <div class="text-end">
                <a href="#" class="btn btn-sm btn-primary w-100">More info</a>
            </div>
        </div>
    </div>
</div>

{{-- Next row --}}
<div class="row g-3 mt-0">
    <div class="col-md-8">
        <div class="card shadow-sm p-3 h-100">
            Left content
            <canvas id="chart1" class="chart"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm p-3 h-100">
            Right content
            <canvas id="chart2" class="chart2"></canvas>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
