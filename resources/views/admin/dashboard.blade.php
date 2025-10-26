@extends('layout.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
<style>
/* ===== THEME ===== */
body {
    background-color: #fffbea;
    color: #0b1b4a;
    font-family: 'Poppins', sans-serif;
}
    .page-header h2 {
        font-weight: 700;
        color: #0b1b4a;
    }

/* ===== WIDGET CARDS ===== */
.widget-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-radius: 15px;
    padding: 25px 30px;
    color: #fff;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    border: none;
    cursor: pointer;
    min-height: 130px;
}

.widget-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

/* Widget color themes */
#card-1 {
    background: linear-gradient(135deg, #2E8B57, #3CB371);
}
#card-2 {
    background: linear-gradient(135deg, #B22222, #DC143C);
}
#card-3 {
    background: linear-gradient(135deg, #0b1b4a, #2c3e80);
}

/* Widget icons */
.widget-icon {
    font-size: 2.5rem;
    background: rgba(255, 255, 255, 0.25);
    padding: 18px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Widget text */
.widget-info h2 {
    font-weight: 700;
    font-size: 2.3rem;
    margin: 0;
    color: #fff;
}

.widget-info p {
    font-weight: 500;
    font-size: 1rem;
    opacity: 0.9;
    margin: 3px 0 0 0;
}

.widget-footer {
    margin-top: 10px;
}

.widget-footer a {
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: 0.3s;
}

.widget-footer a:hover {
    text-decoration: underline;
    color: #fffbea;
}

/* ===== CHARTS ===== */
.chart {
    width: 100% !important;
    height: 40vh !important;
    max-height: 400px;
}

.large-pie {
    height: 45vh !important;
}

/* ===== TABLE DESIGN ===== */
.table {
    border-radius: 10px;
    overflow: hidden;
}
.table thead.table-dark th {
    background: #0b1b4a !important;
    border: none;
    color: #fff;
    font-size: 0.95rem;
    letter-spacing: 0.5px;
}
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #fff9dc !important;
}
.table-striped > tbody > tr:nth-of-type(even) {
    background-color: #fffbea !important;
}
.table-hover tbody tr:hover {
    background-color: #fdf3c5 !important;
    transition: 0.2s ease;
}
.card-body h2 {
    color: #0b1b4a;
    font-weight: 700;
}


@media (max-width: 576px) {
    .row.g-4.d-flex.justify-content-center {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        justify-items: center;
    }

    .widget-card {
        width: 100%;
        max-width: 120px;
        min-height: 100px;
        padding: 12px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        border-radius: 10px;
    }

    .widget-info h2 {
        font-size: 1.2rem;
    }

    .widget-info p {
        font-size: 0.8rem;
        margin: 4px 0;
    }

    .widget-icon {
        font-size: 1.5rem;
        padding: 10px;
        margin-bottom: 6px;
    }

    .widget-footer a {
        font-size: 0.75rem;
    }

    /* Make charts smaller */
    .chart {
        height: 220px !important;
    }
}


</style>
