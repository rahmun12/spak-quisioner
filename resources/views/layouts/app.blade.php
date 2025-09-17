<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kuisioner</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        /* Navbar konsisten pakai Roboto */
        .navbar-custom,
        .navbar-custom .nav-link,
        .navbar-custom .login-btn {
            font-family: 'Roboto', sans-serif;
        }

        .navbar-custom {
            background-color: #8ed3f5;
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

        .login-btn {
            background-color: #005EB8;
            color: white;
            font-weight: 600;
            border: none;
            padding: 6px 20px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            background-color: #ffffff;
            color: #005EB8;
            border: 1px solid #005EB8;
        }

        @media (max-width: 991.98px) {
            .navbar-nav {
                background-color: #87CEEB;
                padding: 1rem;
                border-radius: 8px;
            }
        }

        /* SweetAlert2 - Light Blue Theme */
        .swal2-popup.blue-swal {
            border-radius: 18px !important;
            padding: 28px 24px !important;
            background: linear-gradient(180deg, #f3faff, #ffffff) !important;
            box-shadow: 0 12px 40px rgba(0, 94, 184, 0.15), 0 0 0 1px rgba(142, 211, 245, 0.25) inset !important;
        }
        .swal2-title {
            color: #004AAD !important;
            font-weight: 700 !important;
            letter-spacing: .2px;
        }
        .swal2-html-container {
            color: #2b3a42 !important;
            font-size: 0.975rem !important;
        }
        .blue-swal-btn.swal2-confirm {
            background: linear-gradient(135deg, #005EB8, #2f8ed6) !important;
            border: none !important;
            box-shadow: 0 6px 18px rgba(0, 94, 184, 0.35) !important;
            border-radius: 12px !important;
            padding: 10px 18px !important;
            font-weight: 600 !important;
        }
        .blue-swal-btn.swal2-confirm:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }
        .swal2-timer-progress-bar {
            background: linear-gradient(90deg, #8ED3F5, #005EB8) !important;
            height: 4px !important;
        }
        .blue-swal-icon {
            width: 80px; height: 80px; border-radius: 50%;
            background: radial-gradient(closest-side, #e9f6ff, #cfeafe);
            display: inline-flex; align-items: center; justify-content: center;
            box-shadow: inset 0 0 0 2px #8ED3F5, 0 8px 18px rgba(0,94,184,0.15);
        }
        .blue-swal-check {
            font-size: 42px; color: #0a74d3; line-height: 1;
        }
    </style>
</head>

<body>

    @if (!request()->is('admin/login*') && !request()->is('admin/register*'))
    <nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
        <div class="container">
            <div class="d-flex align-items-center">
                <a href="{{ route('landing') }}" class="d-flex align-items-center text-decoration-none">
                    <img src="{{ asset('images/pemkot.png') }}" alt="Pemkot Logo" class="logo-img">
                    <img src="{{ asset('images/bapenda.png') }}" alt="Bapenda Logo" class="logo-img">
                </a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('landing') ? 'active' : '' }}"
                            href="{{ route('landing') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('data.form') ? 'active' : '' }}"
                            href="{{ route('data.form') }}">Data Diri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Kuisioner</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.login') }}" class="btn login-btn ms-2">LOGIN</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endif

    {{-- 🔹 Kondisi: kalau halaman punya section fullpage, tidak pakai container --}}
    @if (View::hasSection('fullpage'))
    @yield('content')
    @else
    <div class="container mt-4">
        @yield('content')
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
@if(session('success'))
<script>
    Swal.fire({
        customClass: {
            popup: 'blue-swal',
            confirmButton: 'blue-swal-btn'
        },
        html: `
            <div class="blue-swal-icon mb-3">
                <span class="blue-swal-check">✓</span>
            </div>
            <h2 class="swal2-title">Berhasil!</h2>
            <div class="swal2-html-container">{{ session('success') }}</div>
        `,
        showConfirmButton: false,
        timer: 2200,
        timerProgressBar: true
    });
</script>
@endif