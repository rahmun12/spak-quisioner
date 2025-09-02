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

        

        /* Box for Score and Interpretation */
        .bp-hero-box {
            position: absolute;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            background: #8ED3F5;
            padding: 30px 40px;
            border-radius: 15px;
            width: 80%;
            max-width: 700px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
            z-index: 2;
        }

        /* Box for Score Scale */
        .score-scale-box {
            position: absolute;
            top: 60%;
            left: 50%;
            transform: translateX(-50%);
            background: #fff;
            padding: 25px 40px;
            border-radius: 15px;
            width: 80%;
            max-width: 700px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            z-index: 2;
            margin-top: 20px;
        }

        .score-scale-box h3 {
            color: #333;
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .score-display h2 {
            font-size: 3.5rem;
            font-weight: 700;
            color: #fff;
            margin: 0 0 10px 0;
            line-height: 1;
        }

        .score-display p {
            font-size: 1.3rem;
            font-weight: 500;
            color: #fff;
            margin-bottom: 20px;
        }

        .scale-items {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 15px;
        }

        .scale-item {
            flex: 1 1 45%;
            min-width: 200px;
            display: flex;
            align-items: center;
            padding: 10px 15px;
            background: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .scale-color {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .scale-range {
            font-weight: 600;
            color: #333;
            margin-right: 15px;
            min-width: 100px;
        }

        .scale-label {
            font-weight: 500;
            color: #333;
        }

        .interpretation {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
        }

        .interpretation p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #fff;
            margin: 0;
        }

        .interpretation p strong {
            color: #fff;
            font-weight: 600;
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

        <!-- Box for Score and Interpretation -->
        <div class="bp-hero-box">
            <div class="score-display">
                <h2>{{ number_format($averageScore, 2) }}</h2>
                <p>Nilai Rata-rata Keseluruhan</p>
                
                <!-- Interpretasi Hasil -->
                <div class="interpretation">
                    <p>Berdasarkan hasil penilaian, kualitas pelayanan Bapenda Kota Malang saat ini berada pada kategori <strong>{{ $scoreCategory['name'] }}</strong>.</p>
                    <p class="mt-2">{{ $scoreCategory['description'] }}</p>
                </div>
            </div>
        </div>

        <!-- Box for Score Scale -->
        <div class="score-scale-box">
            <h3>Skala Penilaian</h3>
            <div class="scale-items">
                <div class="scale-item">
                    <span class="scale-color" style="background-color: #28a745;"></span>
                    <span class="scale-range">4.51 - 5.00</span>
                    <span class="scale-label">Sangat Baik</span>
                </div>
                <div class="scale-item">
                    <span class="scale-color" style="background-color: #17a2b8;"></span>
                    <span class="scale-range">3.51 - 4.50</span>
                    <span class="scale-label">Baik</span>
                </div>
                <div class="scale-item">
                    <span class="scale-color" style="background-color: #ffc107;"></span>
                    <span class="scale-range">2.51 - 3.50</span>
                    <span class="scale-label">Cukup</span>
                </div>
                <div class="scale-item">
                    <span class="scale-color" style="background-color: #dc3545;"></span>
                    <span class="scale-range">1.00 - 2.50</span>
                    <span class="scale-label">Kurang</span>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footerU')
@endsection
