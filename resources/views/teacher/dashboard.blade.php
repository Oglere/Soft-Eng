<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D.A.R.A Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidenav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/teacher/dashboard.css') }}">
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
        <div>
            {{-- <img src="{{ asset('images/DARA.png') }}" alt="Logo"> --}}
        </div>
        <div class="navbar-right">
            <div class="notification-wrapper">
                <button id="notifBtn" class="notif-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" width="24" height="24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span id="notifBadge" class="notif-badge" style="display:none;">0</span>
                </button>

                <div id="notifDropdown" class="notif-dropdown hidden">
                    <h4>Notifications</h4>
                    <ul id="notifList"></ul>
                </div>
            </div>

            <div class="profile">

                <div class="profile-info">
                    <p>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</p>

                    <p>Teacher</p>
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
                        <a href="<?php echo e(url('/teacher/dashboard')); ?>" class="active">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h4v11H3zM10 3h4v18h-4zM17 6h4v15h-4z" />
                            </svg>
                            Dashboard
                        </a>
                        <a href="/">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" width="24" height="24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Search Studies
                        </a>
                        <a href="<?php echo e(url('/teacher/submitted')); ?>">
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
                            <a href="<?php echo e(url('/teacher/account_setting')); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A1 1 0 015 17V7a1 1 0 011-1h3.382a1 1 0 01.894.553l1.382 2.764a1 1 0 00.894.553H19a1 1 0 011 1v6a1 1 0 01-.121.496l-2.382 4.764a1 1 0 01-.894.553H6a1 1 0 01-.879-.496z" />
                                </svg>
                                Account Settings
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

        <!-- Main -->
        <main class="main">
            <h2>Welcome, <?php echo e(auth()->user()->first_name); ?>! You have</h2>
            <div class="cards">
                <!-- Top row -->
                <div class="top-row">
                    <a href="{{ route('teacher.submitted.list', ['status' => 'approved']) }}" class="card blue">
                        <p class="label">Approved Studies</p>
                        <p class="number">{{ $approved }}</p>
                        <?xml ?><svg data-name="Layer 1" id="Layer_1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title/><path d="M22.41,10.59,20.36,8.54V5.63a2,2,0,0,0-2-2H15.46l-2.05-2a2,2,0,0,0-2.82,0L8.54,3.64H5.63a2,2,0,0,0-2,2V8.54l-2,2.05A2,2,0,0,0,1,12a2,2,0,0,0,.58,1.41l2.06,2.05v2.91a2,2,0,0,0,2,2H8.54l2.05,2.05A2,2,0,0,0,12,23a2,2,0,0,0,1.41-.58l2.05-2.06h2.91a2,2,0,0,0,2-2V15.46l2.05-2.05a2,2,0,0,0,0-2.82Zm-4.05,4.05v3.72H14.64L12,21,9.36,18.36H5.64V14.64L3,12,5.64,9.36V5.64H9.36L12,3l2.64,2.64h3.72V9.36L21,12Z"/><polygon points="11 12.73 8.71 10.44 7.29 11.85 11 15.56 16.71 9.85 15.29 8.44 11 12.73"/></svg>
                    </a>

                    <a href="{{ route('teacher.submitted.list', ['status' => 'pending']) }}" class="card orange">
                        <p class="label">Pending Studies</p>
                        <p class="number">{{ $pending }}</p>
                        <?xml ?><svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:2px;}</style></defs><title/><g data-name="83-book" id="_83-book"><path class="cls-1" d="M11,23H7.17A4.12,4.12,0,0,0,3,26.61,4,4,0,0,0,7,31h8"/><path class="cls-1" d="M3,27V5A4,4,0,0,1,7,1H29V13"/><circle class="cls-1" cx="23" cy="23" r="8"/><line class="cls-1" x1="27" x2="19" y1="23" y2="23"/></g></svg>
                    </a>

                    <a href="{{ route('teacher.submitted.list', ['status' => 'rejected']) }}" class="card red">
                        <p class="label">Rejected Studies</p>
                        <p class="number">{{ $rejected }}</p>
                        <?xml ?><svg viewBox="0 0 96 96" xmlns="http://www.w3.org/2000/svg"><title/><g><path d="M48,0A48,48,0,1,0,96,48,48.0512,48.0512,0,0,0,48,0Zm0,84A36,36,0,1,1,84,48,36.0393,36.0393,0,0,1,48,84Z"/><path d="M64.2422,31.7578a5.9979,5.9979,0,0,0-8.4844,0L48,39.5156l-7.7578-7.7578a5.9994,5.9994,0,0,0-8.4844,8.4844L39.5156,48l-7.7578,7.7578a5.9994,5.9994,0,1,0,8.4844,8.4844L48,56.4844l7.7578,7.7578a5.9994,5.9994,0,0,0,8.4844-8.4844L56.4844,48l7.7578-7.7578A5.9979,5.9979,0,0,0,64.2422,31.7578Z"/></g></svg>
                    </a>
                </div>
            </div>
        </main>
    </div>
<script>
    async function loadNotifications(saveToStorage = true) {
        const notifBadge = document.getElementById('notifBadge');
        const notifList = document.getElementById('notifList');

        try {
            // Fetch teacher notifications
            const res = await fetch('{{ route("teacher.notifications") }}');
            const data = await res.json();

            notifList.innerHTML = '';

            if (data.length === 0) {
                notifBadge.style.display = 'none';
                notifList.innerHTML = '<li>No new notifications.</li>';
                if (saveToStorage) localStorage.setItem('teacherNotifCount', 0);
                return;
            }

            // Get read notifications from localStorage
            const readNotifs = JSON.parse(localStorage.getItem('teacherReadNotifs') || '[]');

            // Filter unread notifications for badge
            const unreadCount = data.filter(n => !readNotifs.includes(n.message)).length;

            notifBadge.style.display = unreadCount > 0 ? 'inline-block' : 'none';
            notifBadge.textContent = unreadCount;

            if (saveToStorage) localStorage.setItem('teacherNotifCount', unreadCount);

            data.forEach(n => {
                const li = document.createElement('li');
                const isRead = readNotifs.includes(n.message);
                li.style.backgroundColor = isRead ? '#fff' : '#fef9c3';
                li.style.cursor = 'pointer';
                li.innerHTML = `
                    ${n.icon}
                    <a href="${n.link}" class="notif-link">${n.message}</a>
                    <br>
                    <small>${n.time}</small>
                `;

                li.addEventListener('click', () => {
                    if (!readNotifs.includes(n.message)) {
                        readNotifs.push(n.message);
                        localStorage.setItem('teacherReadNotifs', JSON.stringify(readNotifs));
                        li.style.backgroundColor = '#fff';

                        const currentBadge = parseInt(notifBadge.textContent) || 0;
                        const newBadge = Math.max(currentBadge - 1, 0);
                        notifBadge.textContent = newBadge;
                        if (newBadge === 0) notifBadge.style.display = 'none';
                    }
                });

                notifList.appendChild(li);
            });

        } catch (error) {
            console.error('Error loading notifications:', error);
        }
    }

    // --- INITIALIZATION ---
    document.addEventListener('DOMContentLoaded', () => {
        const notifBadge = document.getElementById('notifBadge');

        // Load saved count from localStorage
        const savedCount = localStorage.getItem('teacherNotifCount');
        if (savedCount && parseInt(savedCount) > 0) {
            notifBadge.textContent = savedCount;
            notifBadge.style.display = 'inline-block';
        } else {
            notifBadge.style.display = 'none';
        }

        // Fetch new notifications immediately
        loadNotifications();

        // Refresh notifications every 10 seconds
        setInterval(() => {
            loadNotifications();
        }, 10000);
    });

    // Toggle dropdown on bell click
    document.getElementById('notifBtn').addEventListener('click', async () => {
        const dropdown = document.getElementById('notifDropdown');
        dropdown.classList.toggle('hidden');
        if (!dropdown.classList.contains('hidden')) {
            await loadNotifications(false);
        }
    });
</script>
</body>
</html>
