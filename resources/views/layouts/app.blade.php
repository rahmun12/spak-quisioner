<!DOCTYPE html>
<html lang="id">

<head>
    <title>Kuisioner</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    </style>
</head>

<body>


    @if (!request()->is('admin/login*') && !request()->is('admin/register*'))
        <nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
            <div class="container">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('images/pemkot.png') }}" alt="Pemkot Logo" class="logo-img">
                    <img src="{{ asset('images/bapenda.png') }}" alt="Bapenda Logo" class="logo-img">
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

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>
