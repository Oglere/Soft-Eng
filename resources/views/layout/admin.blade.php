<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D.A.R.A Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #fffbea;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* use min-height instead of fixed height */
            overflow-y: auto;  /* allow scrolling and SweetAlert overlay to display properly */
            overflow-x: hidden;
        }

        /* ===== HEADER ===== */
        header {
            background: #f9f9f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid #e5e5e5;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.5rem;
            color: #0b1b4a;
        }

        .header-left img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            background: #fff;
        }

        /* Hamburger menu (hidden on desktop) */
        .hamburger {
            display: none;
            font-size: 1.6rem;
            color: #0b1b4a;
            cursor: pointer;
            background: none;
            border: none;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-right .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .user-name {
            font-weight: 600;
            color: #111;
        }

        .user-role {
            font-size: 0.85rem;
            color: #777;
        }

        .header-right .icon {
            background: #fff;
            border-radius: 50%;
            padding: 8px;
            box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        /* ===== MAIN CONTENT ===== */
        .main {
            display: flex;
            flex: 1;
            overflow: hidden;
            background: #fffbea;
            transition: all 0.3s ease;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            background: #f8f9fc;
            width: 250px;
            border-right: 1px solid #e5e5e5;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.03);
            position: sticky;
            top: 0;
            height: calc(100vh - 65px);
            transition: all 0.3s ease;
        }

        .sidebar-content {
            overflow-y: auto;
            padding: 20px;
            flex-grow: 1;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .menu h5 {
            color: #9b9b9b;
            font-size: 0.8rem;
            margin: 10px 0;
            letter-spacing: 1px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: #222;
            font-weight: 500;
            padding: 10px 14px;
            border-radius: 10px;
            transition: 0.2s;
        }

        .menu a i {
            font-size: 1.1rem;
            color: #0b1b4a;
        }

        .menu a:hover,
        .menu a.active {
            background: #0b1b4a;
            color: #fff;
        }

        .menu a:hover i,
        .menu a.active i {
            color: #fff;
        }

        /* ===== CONTENT AREA ===== */
        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            height: calc(100vh - 65px);
        }

        /* ===== LOGOUT BUTTON ===== */
        .logout-section {
            padding: 20px;
            border-top: 1px solid #e5e5e5;
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fef2f2;
            color: #c53030;
            border: none;
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 500;
            transition: 0.2s;
            width: 100%;
            text-align: left;
        }

        .logout-btn:hover {
            background: #c53030;
            color: white;
        }

        .logout-btn i {
            font-size: 1.1rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .hamburger {
                display: block;
            }

            .sidebar {
                position: fixed;
                left: -260px;
                top: 65px;
                height: calc(100vh - 65px);
                z-index: 999;
                width: 250px;
                background: #f8f9fc;
            }

            .sidebar.show {
                left: 0;
            }

            .content {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .header-right .user-info {
                display: none;
            }

            .header {
                padding: 10px 20px;
            }

            .content {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- ===== HEADER ===== -->
    <header>
        <div class="header-left">
            <button class="hamburger" id="menuToggle"><i class="fa-solid fa-bars"></i></button>
            <img src="{{ asset('images/DARA.png') }}" alt="Logo">
        </div>
        <div class="header-right">
            <div class="icon"><i class="fa-regular fa-bell"></i></div>
            <div class="user-info">
                <span class="user-name">{{ auth()->user()->first_name ?? 'Admin' }} {{ auth()->user()->last_name ?? '' }}</span>
                <span class="user-role">Administrator</span>
            </div>
        </div>
    </header>

    <!-- ===== MAIN SECTION ===== -->
    <div class="main">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-content">
                <div class="menu">
                    <h5>MENU</h5>
                    <a href="{{ url('/admin/dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-house"></i><span>Dashboard</span>
                    </a>

                    <a href="{{ url('/') }}" class="{{ request()->is('search-studies') ? 'active' : '' }}">
                        <i class="fa-solid fa-magnifying-glass"></i><span>Search Studies</span>
                    </a>

                    <a href="{{ url('/admin/manage-users') }}" class="{{ request()->is('admin/manage-users*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i><span>Manage Users</span>
                    </a>


                    <a href="{{ url('/admin/storage') }}" class="{{ request()->is('admin/storage') ? 'active' : '' }}">
                        <i class="fa-solid fa-database"></i><span>Storage</span>
                    </a>

                    <h5>SETTINGS</h5>
                    <a href="{{ url('/admin/account_setting') }}" class="{{ request()->is('admin/account_setting') ? 'active' : '' }}">
                        <i class="fa-solid fa-gear"></i><span>Account</span>
                    </a>
                </div>
            </div>

            <!-- Logout button -->
            <div class="logout-section">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Log out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- ===== MAIN CONTENT AREA ===== -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script>
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });

        // Close sidebar when clicking outside (for mobile)
        document.addEventListener('click', function(e) {
            if (!sidebar.contains(e.target) && !menuToggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</body>
</html>
