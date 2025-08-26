@extends('layouts.app')

@section('content')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Poppins:wght@600;700&display=swap');

        body {
            background: linear-gradient(135deg, rgba(0, 94, 184, 0.95) 50%, #F2F5F7 50%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.6s ease-in-out;
        }

        .login-left {
            background: linear-gradient(135deg, #005EB8, #87CEEB);
            color: #fff;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 2rem;
            text-align: center;
        }

        .login-left h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .login-left p {
            max-width: 300px;
            font-size: 0.95rem;
            line-height: 1.5;
            opacity: 0.95;
        }

        .login-right {
            flex: 1;
            padding: 3rem 2.5rem;
        }

        .login-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1.8rem;
            color: #005EB8;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            font-size: 0.95rem;
            color: #555;
            margin-bottom: 2.5rem;
        }

        .input-group-text {
            background: #F2F5F7;
            border: 1px solid #cfd8e3;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .form-control {
            border-radius: 0 10px 10px 0;
            padding: 12px 14px;
            border: 1px solid #cfd8e3;
            background: #F9FAFB;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #005EB8;
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 94, 184, 0.12);
        }

        .btn-login {
            background: #007ACC;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            color: #fff;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #ffffff;
            color: #007ACC;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 94, 184, 0.25);
            border: 1px solid #007ACC;
        }


        .extra-links {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .extra-links a {
            color: #005EB8;
            text-decoration: none;
            margin: 0 8px;
        }

        .extra-links a:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="login-container">
        <div class="login-left">
            <h2>Selamat Datang</h2>
            <p>Kelola sistem dan data Anda dengan mudah melalui Admin Portal kami.</p>
        </div>

        <div class="login-right">
            <h2 class="login-title">Admin Portal</h2>
            <p class="login-subtitle">Masuk untuk melanjutkan</p>

            @if ($errors->any())
                <div class="alert alert-danger rounded-3">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success rounded-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                        name="username" value="{{ old('username') }}" placeholder="Masukkan username" required autofocus>
                    @error('username')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" placeholder="Masukkan password" required>
                </div>



                <div class="d-grid">
                    <button type="submit" class="btn btn-login">Masuk</button>
                </div>
            </form>

            <div class="extra-links">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Lupa Password?</a>
                @endif
                <a href="{{ route('admin.register.form') }}">Buat Akun</a>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
