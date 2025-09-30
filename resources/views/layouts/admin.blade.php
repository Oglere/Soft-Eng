<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Admin Panel')</title>
        <link rel="stylesheet" href="{{ asset('css/admin/layout.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/components.css') }}">
        <link rel="stylesheet" href="{{ asset('css/admin/chart.css') }}">


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    </head>
    <body>
        <!-- Top Nav -->
        <header>
            <button class="menu-toggle">☰</button> <!-- hamburger -->
            <div class="spacer"></div>
            <h1>DARA</h1>

        </header>

        <!-- Side Nav + Main Content -->
        <div class="content-area">
            <!-- Sidebar -->
            @include('layouts.admin_sidenav')

            <!-- Main -->
            <main>
                @yield('content')
            </main>
        </div>

        <script>
            const toggleBtn = document.querySelector('.menu-toggle');
            const sidebar = document.querySelector('.sidebar');
            const contentArea = document.querySelector('.content-area');

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                contentArea.classList.toggle('shift');
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{ asset('js/chart.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    </body>
</html>
