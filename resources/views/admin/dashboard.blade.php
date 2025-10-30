@extends('layout.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{asset('css/admin/dashboard.css')}}">


@section('content')
    <div class="page-header">
        <h2>Dashboard</h2>
    </div>

<div class="container-fluid px-3 py-3">
    <div class="row g-4 d-flex justify-content-center">
        <!-- Total Users Widget -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="widget-card" id="card-1">
                <div class="widget-info">
                    <h2 id="usersCount">0</h2>
                    <p>Total Users</p>
                    <div class="widget-footer">
                    </div>
                </div>
                <div class="widget-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <!-- Total Admins Widget -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="widget-card" id="card-2">
                <div class="widget-info">
                    <h2 id="adminsCount">0</h2>
                    <p>Total Admins</p>
                    <div class="widget-footer">
                    </div>
                </div>
                <div class="widget-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
        </div>

        <!-- Total Storage Widget -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="widget-card" id="card-3">
                <div class="widget-info">
                    <h2 id="storageCount">0</h2>
                    <p>Total Storage</p>
                    <div class="widget-footer">
                    </div>
                </div>
                <div class="widget-icon">
                    <i class="fas fa-database"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mt-4 align-items-stretch">
        <div class="col-lg-7 col-md-12">
            <div class="card shadow-sm p-3 bg-white h-100">
                <canvas id="chart1" class="chart"></canvas>
            </div>
        </div>

        <div class="col-lg-5 col-md-12">
            <div class="card shadow-sm p-3 bg-white h-100 d-flex align-items-center justify-content-center">
                <canvas id="chart2" class="chart large-pie"></canvas>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h2 class="mb-4 fw-bold text-dark">Recent Users Online</h2>
                    <div class="table-responsive">
                        <table class="table align-middle table-striped table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 60%">Name</th>
                                    <th>Last Online</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentUsers as $user)
                                    <tr>
                                        <td>{{ $user->last_name }}, {{ $user->first_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($user->last_login)->format('M d, Y h:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">No recent logins.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Chart.js & Count Animation --}}
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="https://kit.fontawesome.com/a2e0b6f6d2.js" crossorigin="anonymous"></script>
<script>
    // Animated Count Function
    function animateCount(id, target, unit = '') {
        let count = 0;
        const speed = 30;
        const step = Math.ceil(target / 40);
        const el = document.getElementById(id);
        const formatNumber = (num) => num.toLocaleString();

        const interval = setInterval(() => {
            count += step;
            if (count >= target) {
                count = target;
                clearInterval(interval);
            }
            el.textContent = formatNumber(count) + (unit ? unit : '');
        }, speed);
    }

    // Animate the widget counts
    animateCount('usersCount', {{ $totalUsers }});
    animateCount('adminsCount', {{ $totalAdmins }});
    animateCount('storageCount', {{ $totalStorageValue }}, '{{ $totalStorageUnit }}');

    // Line Chart
    new Chart(document.getElementById('chart1'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Published',
                    data: [
                        @for ($i = 1; $i <= 12; $i++)
                            {{ $publishedDocs[$i] ?? 0 }},
                        @endfor
                    ],
                    borderColor: '#0b1b4a',
                    backgroundColor: 'rgba(11, 27, 74, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Unpublished',
                    data: [
                        @for ($i = 1; $i <= 12; $i++)
                            {{ $unpublishedDocs[$i] ?? 0 }},
                        @endfor
                    ],
                    borderColor: '#b22222',
                    backgroundColor: 'rgba(178, 34, 34, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { labels: { usePointStyle: true, font: { size: 13 } } }
            },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    // Pie Chart
    const statusLabels = {!! json_encode(array_keys($docStatuses)) !!};
    const statusData = {!! json_encode(array_values($docStatuses)) !!};

    new Chart(document.getElementById('chart2'), {
        type: 'pie',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: [
                    '#f0c75e', '#2E8B57', '#4682B4', '#B22222', '#8B4513', '#6A5ACD'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    align: 'center',
                    labels: { usePointStyle: true, boxWidth: 15, padding: 20, font: { size: 13 }, color: '#0b1b4a' }
                },
                title: {
                    display: true,
                    text: 'Document Status Overview',
                    font: { size: 16, family: 'Poppins', weight: '600' },
                    color: '#0b1b4a'
                }
            },
            layout: { padding: { right: 40 } }
        }
    });

</script>
@endsection
