<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D.A.R.A Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student/dashboard.css') }}">
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
        <h1>D.A.R.A</h1>

        <div class="navbar-right">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button>

            <div class="profile">
        
                <div class="profile-info">
                    <p>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</p>

                    <p>Student</p>
                </div>
            </div>
        </div>
  </div>

    <!-- Layout -->
    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div>
                <div class="menu-section">
                    <p class="menu-title">Menu</p>
                    <div class="menu">
                        <a href="<?php echo e(url('/student/dashboard')); ?>" class="active">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h4v11H3zM10 3h4v18h-4zM17 6h4v15h-4z" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="<?php echo e(url('/student/submission')); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                            Submit Studies
                        </a>
                        <a href="<?php echo e(url('/student/doc_status')); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            Submitted Studies
                        </a>
                    </div>
                </div>

                <div class="menu-section">
                    <p class="menu-title">Settings</p>
                        <div class="menu">
                            <a href="<?php echo e(url('/student/account_setting')); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A1 1 0 015 17V7a1 1 0 011-1h3.382a1 1 0 01.894.553l1.382 2.764a1 1 0 00.894.553H19a1 1 0 011 1v6a1 1 0 01-.121.496l-2.382 4.764a1 1 0 01-.894.553H6a1 1 0 01-.879-.496z" />
                                </svg>
                                Account
                            </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                            @csrf
                        </form>

                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="inline-flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                            </svg>
                            Log out
                        </a>
                    </div>
                </div>
            </div>
        </aside>

        <div class="teacher-dashboard">
            {{-- Welcome Message --}}
            <h2 class="welcome-message">
                Welcome, {{ $user->first_name }}! You Have
            </h2>

            {{-- Stats Overview --}}
            <div class="stats-overview">
                {{-- Pending --}}
                <div class="stat-box">
                    <img src="{{ asset('images/book.png') }}" alt="Pending">
                    <span class="count">{{ $pending }}</span>
                    <p>Studies to Review</p>
                </div>

                {{-- Approved --}}
                <div class="stat-box">
                    <img src="{{ asset('images/approved.png') }}" alt="Approved">
                    <span class="count">{{ $approved }}</span>
                    <p>Approved Studies</p>
                </div>

                {{-- Rejected --}}
                <div class="stat-box">
                    <img src="{{ asset('images/reject.png') }}" alt="Rejected">
                    <span class="count">{{ $rejected }}</span>
                    <p>Rejected Studies</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


