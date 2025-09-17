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
        height: 100%;
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
        animation: wave 10s ease infinite;
    }
    .icon-star  { background: linear-gradient(135deg, #ffb400, #ffdd80); }

    /* Warna & animasi ikon */
    .icon-box i {
        position: relative;
        z-index: 1;
    }
    .icon-users i { color: #fff; }
    .icon-file i  { color: #fff; }
    .icon-star i  { color: #333; }

    @keyframes wave {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    .card-content h3 {
        font-size: 2rem;
        font-weight: 700; /* angka KPI tidak terlalu bold */
        margin-bottom: 8px;
        color: #111;
    }

    .card-content p {
        font-size: 1.2rem;
        color: #555;
        margin: 0;
    }

    /* Section cards */
    .section-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        padding: 24px;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #0b2545;
        margin-bottom: 16px;
    }

    .progress {
        height: 12px;
        border-radius: 999px;
        background: #eef3f7;
        overflow: hidden;
    }

    .progress-bar {
        font-size: 0.75rem;
    }

    .quick-links .btn {
        border-radius: 10px;
        padding: 6px 10px; /* lebih kecil */
        font-size: .9rem;  /* kecilkan font */
        line-height: 1.2;
        font-weight: 500; /* kurangi bold di tombol */
    }

    /* Kurangi ketebalan font badge agar tidak terlalu bold */
    .section-card .badge {
        font-weight: 500;
    }

    /* Nilai skor tanpa bold berlebihan */
    .score-value {
        font-weight: 500;
    }
</style>

<div class="container mt-5">
    <h1 class="dashboard-title">Dashboard Admin</h1>

    <div class="row g-4 align-items-stretch">
        <div class="col-12 col-md-4">
            <div class="card-stat h-100">
                <div class="icon-box icon-users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-content">
                    <h3>{{ number_format($totalRespondents) }}</h3>
                    <p>Total Responden</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card-stat h-100">
                <div class="icon-box icon-file">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="card-content">
                    <h3>{{ number_format($totalQuestionnaires) }}</h3>
                    <p>Kuisioner Masuk</p>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card-stat h-100">
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

    @php
        $scorePercent = min(100, max(0, ($averageScore / 5) * 100));
        $barClass = $averageScore >= 4.51 ? 'bg-success' : ($averageScore >= 3.51 ? 'bg-info' : ($averageScore >= 2.51 ? 'bg-warning' : 'bg-danger'));
        $category = $averageScore >= 4.51 ? 'Sangat Baik' : ($averageScore >= 3.51 ? 'Baik' : ($averageScore >= 2.51 ? 'Cukup' : 'Kurang'));
    @endphp

    <div class="row g-4 mt-1">
        <div class="col-12 col-lg-7">
            <div class="section-card">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="section-title mb-0">Ringkasan Kualitas Pelayanan</div>
                    <span class="badge {{ $barClass }}">{{ $category }}</span>
                </div>
                <div class="mb-2 small text-muted">Rata-rata skor saat ini</div>
                <div class="d-flex align-items-center gap-3">
                    <div style="min-width: 80px;">
                        <span class="score-value">{{ number_format($averageScore, 2, ',', '.') }}</span> / 5.00
                    </div>
                    <div class="flex-grow-1">
                        <div class="progress">
                            <div class="progress-bar {{ $barClass }}" role="progressbar" style="width: {{ $scorePercent }}%;" aria-valuenow="{{ $scorePercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 d-flex flex-wrap gap-2 small">
                    <span class="badge bg-success">4.51–5.00 Sangat Baik</span>
                    <span class="badge bg-info text-dark">3.51–4.50 Baik</span>
                    <span class="badge bg-warning text-dark">2.51–3.50 Cukup</span>
                    <span class="badge bg-danger">1.00–2.50 Kurang</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-5">
            <div class="section-card quick-links">
                <div class="section-title">Tautan Cepat</div>
                <div class="d-flex flex-wrap gap-2 mb-2">
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-primary"><i class="fas fa-database me-2"></i>Data Kuisioner</a>
                    <a href="{{ route('admin.answers') }}" class="btn btn-outline-secondary"><i class="fas fa-list-check me-2"></i>Nilai Kuisioner</a>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.answers', ['export' => 'excel']) }}" class="btn btn-success">
                        <i class="fas fa-file-excel me-2"></i>Export Nilai Kuisioner (Jawaban)
                    </a>
                    <a href="{{ route('admin.users.export') }}" class="btn btn-warning text-dark">
                        <i class="fas fa-file-export me-2"></i>Export Data Kuisioner (Responden)
                    </a>
                </div>
                <hr>
                <div class="small d-flex flex-wrap gap-2 align-items-center">
                    <span class="badge bg-success"><i class="fas fa-file-excel me-1"></i> Nilai Kuisioner</span>
                    <span class="badge bg-warning text-dark"><i class="fas fa-file-export me-1"></i> Data Kuisioner</span>
                    <span class="text-muted">— Pilih sesuai kebutuhan ekspor Anda.</span>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- FontAwesome (lebih stabil) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
