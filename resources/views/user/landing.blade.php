@extends('layouts.app')

@section('fullpage', true)


@section('content')
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .hero-section {
            position: relative;
            background: url('{{ asset('images/tugu-malang.jpg') }}') no-repeat center center;
            background-size: cover;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow: hidden;
        }

        .hero-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(38, 38, 38, 0.4);
            z-index: 1;
        }

        .hero-box {
            background: rgba(255, 255, 255, 0.70);
            padding: 70px;
            border-radius: 30px;
            max-width: 1000px;
            text-align: left;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 2;
        }

        .hero-box h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #005EB8;
            margin-bottom: 20px;
        }

        .hero-box p {
            font-size: 1rem;
            font-weight: 400;
            color: #333;
            line-height: 1.7;
        }

        .lion {
            position: absolute;
            right: -7px;
            bottom: -15px;
            width: 350px;
            z-index: 3;
        }

        /* section untuk gambar bp-bg */
        .bp-section {
            position: relative;
            text-align: center;
            margin: 50px 0;
        }

        .bp-section img {
            max-width: 100%;
            height: auto;
            filter: blur(3px);
            opacity: 0.9;
        }

        /* Hero box tambahan di atas bp-bg */
        .bp-hero-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #8ED3F5;
            padding: 100px;
            border-radius: 25px;
            max-width: 800px;
            width: 90%;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            z-index: 2;
        }

        .bp-hero-box h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 15px;
        }

        .bp-hero-box p {
            font-size: 1rem;
            font-weight: 400;
            color: #fff;
        }
    </style>

    <div class="hero-section">
        <div class="hero-box">
            <h1>Selamat Datang <br> di Bapenda Kota Malang</h1>
            <p>
                Badan Pendapatan Daerah (Bapenda) Kota Malang bertugas membantu Wali Kota dalam
                merumuskan dan melaksanakan kebijakan di bidang pendapatan daerah, terutama pengelolaan pajak
                dan retribusi, guna meningkatkan penerimaan asli daerah.
            </p>
        </div>

        <!-- Tambah gambar singa -->
        <img src="{{ asset('images/singa1.png') }}" alt="Singa" class="lion">
    </div>

    <!-- Bagian gambar bp-bg setelah hero -->
    <div class="bp-section">
        <img src="{{ asset('images/bp-bg.png') }}" alt="BP Background">

        <!-- Hero box baru di atas bp-bg -->
        <div class="bp-hero-box">
            <h2>80,00%</h2>
            <p>Presentase Nilai Keseluruhan</p>
        </div>
    </div>
    @include('layouts.footerU')
@endsection
