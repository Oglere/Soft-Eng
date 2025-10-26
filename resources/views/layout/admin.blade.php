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
            height: 100vh;
            overflow: hidden; /* prevent body scroll */
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
            height: calc(100vh - 65px); /* subtract header height */
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
        @media (max-width: 900px) {
            .sidebar {
                width: 70px;
            }

            .sidebar-content {
                padding: 15px 5px;
            }

            .menu a span {
                display: none;
            }

            .menu a {
                justify-content: center;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <!-- ===== HEADER ===== -->
    <header>
        <div class="header-left">
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
        <aside class="sidebar">
            <div class="sidebar-content">
                <div class="menu">
                    <h5>MENU</h5>
                    <a href="{{ url('/admin/dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-house"></i><span>Dashboard</span>
                    </a>

                    <a href="{{ url('/') }}">
                        <i class="fa-solid fa-search"></i><span>Search Studies</span>
                    </a>

                    <a href="{{ url('/admin/manage-users') }}" class="{{ request()->is('admin/manage-users*') ? 'active' : '' }}">
                        <i class="fa-solid fa-users"></i><span>Manage Users</span>
                    </a>

                    <a href="{{ url('/admin/storage') }}" class="{{ request()->is('admin/storage') ? 'active' : '' }}">
                        <i class="fa-solid fa-database"></i><span>Storage</span>
                    </a>

                    <h5>SETTINGS</h5>
                    <a href="{{ url('/admin/account_setting') }}" class="{{ request()->is('admin/account-setting') ? 'active' : '' }}">
                        <i class="fa-solid fa-gear"></i><span>Account</span>
                    </a>
                </div>
            </div>

            <!-- Logout button section always at the bottom -->
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
</body>
</html>
