<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Kuisioner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .navbar-custom {
            background-color: #8ED3F5;
            padding: 0.7rem 1rem;
        }

        .logo-img {
            height: 50px;
            margin-right: 10px;
        }

        .nav-link {
            color: #004AAD !important;
            font-weight: 600;
            transition: all 0.3s ease-in-out;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #013982 !important;
            text-decoration: underline;
        }

        .navbar-nav .nav-item {
            margin: 0 8px;
        }

        .logout-btn {
            background-color: #005EB8;
            color: white;
            font-weight: 600;
            border: none;
            padding: 6px 20px;
            border-radius: 12px;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #00439b;
        }

        @media (max-width: 991.98px) {
            .navbar-nav {
                background-color: #87CEEB;
                padding: 1rem;
                border-radius: 8px;
            }
        }
    </style>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
        <div class="container">
            <div class="d-flex align-items-center">
                <img src="{{ asset('images/pemkot.png') }}" alt="Pemkot Logo" class="logo-img">
                <img src="{{ asset('images/bapenda.png') }}" alt="Bapenda Logo" class="logo-img">
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" 
                           href="{{ route('admin.users') }}">Data Kuisioner</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.answers') ? 'active' : '' }}" 
                           href="{{ route('admin.answers') }}">Nilai Kuisioner</a>
                    </li>
                    <li class="nav-item">
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="button" class="logout-btn ms-2" id="logout-btn">LOGOUT</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten --}}
    <div class="container mt-4">
        @yield('content')
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('logout-btn').addEventListener('click', function () {
            Swal.fire({
                title: 'Yakin mau logout?',
                text: "Anda akan keluar dari halaman admin.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        });
    </script>
</body>
</html>
