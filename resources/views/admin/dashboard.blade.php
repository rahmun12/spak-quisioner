@extends('layouts.admin')

@section('content')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #e6f0fa, #ffffff);
    }

    .dashboard-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #000000;
        margin-bottom: 40px;
        text-align: center;
    }

    /* Card Style */
    .card-stat {
        display: flex;
        align-items: center;
        gap: 30px;
        background: #fff;
        border-radius: 20px;
        padding: 35px;
        text-align: left;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        margin-bottom: 25px;
        width: 100%;
        min-height: 130px;
    }

    .card-stat:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    /* Icon Circle */
    .icon-box {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 2rem;
        position: relative;
        overflow: hidden;
    }

    /* Warna background */
    .icon-users { background: linear-gradient(135deg, #005EB8, #8ED3F5); }
    .icon-file  { 
        background: linear-gradient(270deg, #8ED3F5, #005EB8, #8ED3F5); 
        background-size: 400% 400%;
        animation: wave 6s ease infinite;
    }
    .icon-star  { background: linear-gradient(135deg, #ffb400, #ffdd80); }

    /* Warna & animasi ikon */
    .icon-box i {
        position: relative;
        z-index: 1;
    }
    .icon-users i { color: #fff; animation: pulse 2s infinite; }
    .icon-file i  { color: #fff; animation: bounce 2s infinite; }
    .icon-star i  { color: #333; animation: spin 4s linear infinite; }

    /* Animasi */
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.2); }
    }

    @keyframes wave {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }

    .card-content h3 {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 8px;
        color: #111;
    }

    .card-content p {
        font-size: 1.2rem;
        color: #555;
        margin: 0;
    }
</style>

<div class="container mt-5">
    <h1 class="dashboard-title">Dashboard Admin</h1>

    <div class="row g-4">
        <div class="col-12">
            <div class="card-stat">
                <div class="icon-box icon-users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-content">
                    <h3>{{ number_format($totalRespondents) }}</h3>
                    <p>Total Responden</p>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card-stat">
                <div class="icon-box icon-file">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="card-content">
                    <h3>{{ number_format($totalQuestionnaires) }}</h3>
                    <p>Kuisioner Masuk</p>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card-stat">
                <div class="icon-box icon-star">
                    <i class="fas fa-star"></i>
                </div>
                <div class="card-content">
                    <h3>{{ number_format($averageScore, 2, ',', '.') }}</h3>
                    <p>Nilai Indeks Persepsi Anti Korupsi</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FontAwesome (lebih stabil) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
