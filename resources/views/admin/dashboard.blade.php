@extends('layout.admin')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


@section('content')


<div class="container-fluid px-3 py-3">
    <div class="row g-4 d-flex justify-content-center">
        <!-- Total Users Widget -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="widget-card" id="card-1">
                <div class="widget-info">
                    <h2 id="usersCount">0</h2>
                    <p>Total Users</p>
                    <div class="widget-footer">
                        <a href="#">More info →</a>
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
                        <a href="#">More info →</a>
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
                        <a href="#">More info →</a>
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
                                <tr>
                                    <td>John Doe</td>
                                    <td>5 minutes ago</td>
                                </tr>
                                <tr>
                                    <td>Jane Smith</td>
                                    <td>10 minutes ago</td>
                                </tr>
                                <tr>
                                    <td>Admin User</td>
                                    <td>20 minutes ago</td>
                                </tr>
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
    function animateCount(id, target) {
        let count = 0;
        const speed = 30;
        const step = Math.ceil(target / 40);
        const el = document.getElementById(id);
        const interval = setInterval(() => {
            count += step;
            if (count >= target) {
                count = target;
                clearInterval(interval);
            }
            el.textContent = count;
        }, speed);
    }

    // Animate the widget counts
    animateCount('usersCount', 21);
    animateCount('adminsCount', 34);
    animateCount('storageCount', 50);

    // Line Chart
    new Chart(document.getElementById('chart1'), {
        type: 'line',
        data: {
            labels: ['Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [
                {
                    label: 'Published',
                    data: [2, 3, 5, 4, 6],
                    borderColor: '#0b1b4a',
                    backgroundColor: 'rgba(11, 27, 74, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Unpublished',
                    data: [1, 2, 2, 3, 1],
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
                legend: {
                    labels: { usePointStyle: true, font: { size: 13 } }
                }
            },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

// Pie Chart
new Chart(document.getElementById('chart2'), {
    type: 'pie',
    data: {
        labels: ['Pending', 'Approved', 'LostDoc', 'Rejected', 'Abandoned', 'Needs Revision'],
        datasets: [{
            data: [15, 25, 10, 20, 5, 25],
            backgroundColor: [
                '#f0c75e', // Pending
                '#2E8B57', // Approved
                '#4682B4', // LostDoc
                '#B22222', // Rejected
                '#8B4513', // Abandoned
                '#6A5ACD'  // Needs Revision
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right', // ✅ move legend to the right
                align: 'center',   // ✅ vertically centered
                labels: {
                    usePointStyle: true,
                    pointStyle: 'circle',
                    boxWidth: 15,
                    padding: 20,
                    font: {
                        size: 13,
                        family: 'Poppins'
                    },
                    color: '#0b1b4a'
                }
            },
            title: {
                display: true,
                text: 'Document Status Overview',
                font: {
                    size: 16,
                    family: 'Poppins',
                    weight: '600'
                },
                color: '#0b1b4a'
            }
        },
        layout: {
            padding: {
                right: 40 // ✅ give space for legend to breathe
            }
        }
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
        height: 300px !important;
    }

 /* ===== TABLE DESIGN FIX FOR BOOTSTRAP ===== */
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

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .widget-card {
            flex-direction: column;
            align-items: flex-start;
        }
        .widget-icon {
            margin-bottom: 10px;
        }
        .widget-info h2 {
            font-size: 1.8rem;
        }
    }
</style>
