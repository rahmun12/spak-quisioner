@extends('layouts.admin')

@section('content')
<style>
    /* Import Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap');

    body {
        font-family: "Poppins", sans-serif;
    }

    /* ===== BUTTON EXCEL ===== */
    .btn-excel {
        background-color: #217346;
        /* hijau Excel */
        color: #fff !important;
        font-weight: 600;
        border: none;
        padding: 6px 14px;
        border-radius: 8px;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-excel:hover {
        background-color: #1a5b34;
        transform: scale(1.05);
        color: #fff !important;
    }

    .btn-excel i {
        font-size: 1rem;
    }

    /* ===== TABEL & STYLE LAIN ===== */
    .table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        font-size: 0.9rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        border-radius: 8px;
        overflow: hidden;
    }

    .table thead th {
        background-color: #005EB8;
        color: #fff;
        font-weight: 600;
        text-align: center;
        padding: 14px 12px;
        border: none;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        padding: 12px 14px;
        vertical-align: middle;
        border-top: 1px solid #e9ecef;
        text-align: center;
        font-size: 0.88rem;
    }

    .col-no {
        width: 60px;
        font-weight: 500;
    }

    .col-nama {
        min-width: 200px;
        text-align: left !important;
        padding-left: 15px !important;
        font-weight: 500;
    }

    .col-tanggal {
        width: 150px;
        font-weight: 500;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9fbff;
    }

    .table-hover tbody tr:hover {
        background-color: #eef5ff;
        transition: background 0.2s ease-in-out;
    }

    .answer-value {
        font-weight: 600;
        color: #005EB8;
    }

    .pagination {
        justify-content: center;
        margin-top: 25px;
    }

    .page-link {
        color: #005EB8;
        border: 1px solid #dee2e6;
        margin: 0 3px;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .page-item.active .page-link {
        background-color: #005EB8;
        border-color: #005EB8;
        color: #fff;
    }

    .page-link:hover {
        color: #003366;
        background-color: #eaf2fb;
    }

    .suggestion-box {
        background: #f8f9fa;
        border-left: 4px solid #005EB8;
        padding: 10px 12px;
        border-radius: 6px;
        margin-top: 8px;
        font-size: 0.85rem;
        line-height: 1.4;
    }

    .no-answers {
        text-align: center;
        padding: 25px;
        color: #6c757d;
        font-style: italic;
        background-color: #f8f9fa;
        border-radius: 6px;
    }

    .page-title {
        font-weight: 600;
        color: #000;
        margin-bottom: 30px;
        text-align: center;
        letter-spacing: 0.5px;
        font-size: 1.75rem;
    }

    .alert-custom {
        background-color: #f0f8ff;
        border: 1px solid #b6daff;
        color: #005EB8;
        border-radius: 8px;
        padding: 14px;
        font-weight: 500;
    }

    .btn-excel {
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        font-size: 0.9rem;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s ease;
    }
    
    .btn-excel {
        background-color: #217346;
        color: #fff !important;
        font-weight: 600;
        border: none;
        padding: 6px 14px;
        border-radius: 8px;
        transition: background 0.3s ease, transform 0.2s ease;
    }
    
    .dashboard-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.75rem;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
        padding: 0;
        line-height: 1.2;
    }

    /* Card Stats */
    .card-stat {
        display: flex;
        align-items: center;
        gap: 20px;
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        height: 100%;
        transition: all 0.3s ease;
    }

    .card-stat:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .icon-box {
        width: 70px;
        height: 70px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
    }

    .card-stat h3 {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
        color: #2c3e50;
    }

    .card-stat p {
        margin: 5px 0 0;
        font-size: 0.95rem;
        color: #6c757d;
    }
</style>

<div class="container py-4">
    <div class="d-flex flex-column">
        <div class="text-center mb-4">
            <h1 class="dashboard-title">Data Jawaban Kuisioner (Nilai)</h1>
        </div>
        <div class="mb-4">
            <form action="{{ route('admin.answers') }}" method="GET" class="d-inline-block">
                @if(request('start_date'))
                <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                @endif
                @if(request('end_date'))
                <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                @endif
                <input type="hidden" name="export" value="excel">
                <button type="submit" class="btn-excel shadow-sm d-flex align-items-center">
                    <i class="fas fa-file-excel me-2"></i>
                    <span>Export Excel</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card-stat">
                <div class="icon-box" style="background-color: #e3f2fd;">
                    <i class="fas fa-database" style="color: #1976d2;"></i>
                </div>
                <div>
                    <h3 class="mb-1">{{ $allUsers->filter(function($user){ return $user->questionnaireAnswers && $user->questionnaireAnswers->count() > 0; })->count() }}</h3>
                    <p class="mb-0 text-muted">Kuisioner Masuk</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card-stat">
                <div class="icon-box" style="background-color: #e8f5e9;">
                    <i class="fas fa-users" style="color: #2e7d32;"></i>
                </div>
                <div>
                    <h3 class="mb-1">{{ $allUsers->count() }}</h3>
                    <p class="mb-0 text-muted">Jumlah Responden</p>
                </div>
            </div>
        </div>
    </div>


    @if ($users->isEmpty())
    <div class="alert-custom text-center">
        <i class="fas fa-info-circle me-2"></i> Tidak ada data yang ditemukan untuk filter yang dipilih.
    </div>
    @else
    <div class="table-responsive bg-white rounded-3 shadow-sm">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-nama">Nama</th>
                    <th class="col-tanggal">Tanggal</th>
                    @foreach ($questions as $question)
                    <th>{{ $loop->iteration }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($users as $user)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td class="col-nama">
                        {{ $user->name }}
                        @if ($user->suggestion)
                        <div class="suggestion-box">
                            <strong>💬 Saran/Keluhan:</strong><br>
                            {{ $user->suggestion }}
                        </div>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>

                    @if ($user->questionnaireAnswers->isEmpty())
                    <td colspan="{{ count($questions) }}" class="text-center">
                        <span class="text-muted">Belum mengisi kuisioner</span>
                    </td>
                    @else
                    @php
                    $answersByQuestion = $user->questionnaireAnswers->keyBy('question_id');
                    @endphp
                    @foreach ($questions as $question)
                    <td class="answer-value">
                        @if (isset($answersByQuestion[$question->id]))
                        @php
                        $answerText =
                        $answersByQuestion[$question->id]->selectedOption->option_text;
                        $value = $answerValues[$answerText] ?? '-';
                        @endphp
                        {{ $value }}
                        @else
                        -
                        @endif
                    </td>
                    @endforeach
                    @endif
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: #f8f9fa; font-weight: 600;">
                    <td colspan="3" class="text-end">Rata-rata per Soal:</td>
                    @php
                    $totalScores = [];
                    $totalResponses = [];
                    $grandTotal = 0;
                    $totalQuestions = 0;

                    // Initialize arrays for each question
                    foreach ($questions as $question) {
                    $totalScores[$question->id] = 0;
                    $totalResponses[$question->id] = 0;
                    }

                    // Calculate totals for each question
                    foreach ($allUsers as $user) {
                    foreach ($user->questionnaireAnswers as $answer) {
                    $answerText = $answer->selectedOption->option_text;
                    $value = $answerValues[$answerText] ?? 0;
                    if (is_numeric($value)) {
                    $totalScores[$answer->question_id] += $value;
                    $totalResponses[$answer->question_id]++;
                    }
                    }
                    }

                    // Calculate and display averages for each question
                    foreach ($questions as $question) {
                    $avg = ($totalResponses[$question->id] > 0)
                    ? number_format($totalScores[$question->id] / $totalResponses[$question->id], 2)
                    : '0.00';

                    if (is_numeric($avg)) {
                    $grandTotal += $avg;
                    $totalQuestions++;
                    }

                    echo "<td class='text-center fw-bold' style='background-color: #e9ecef;'>".$avg."</td>";
                    }

                    // Calculate overall average
                    $overallAverage = ($totalQuestions > 0)
                    ? number_format($grandTotal / $totalQuestions, 2)
                    : '0.00';
                    @endphp
                </tr>
                <tr style="background-color: #e9ecef; font-weight: 700; font-size: 1.05em;">
                    <td colspan="3" class="text-end">Rata-rata Keseluruhan:</td>
                    <td colspan="{{ count($questions) }}" class="text-center">
                        {{ $overallAverage }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->appends([
            'start_date' => request('start_date'),
            'end_date' => request('end_date')
        ])->links('pagination::bootstrap-5') }}
    </div>

    @php
    // Determine the criteria based on the overall average
    $criteria = '';
    $criteriaClass = '';

    if ($overallAverage >= 4.51) {
    $criteria = 'Sangat Baik';
    $criteriaClass = 'text-success';
    } elseif ($overallAverage >= 3.51) {
    $criteria = 'Baik';
    $criteriaClass = 'text-primary';
    } elseif ($overallAverage >= 2.51) {
    $criteria = 'Cukup';
    $criteriaClass = 'text-warning';
    } elseif ($overallAverage >= 1.00) {
    $criteria = 'Kurang';
    $criteriaClass = 'text-danger';
    } else {
    $criteria = 'Tidak Ada Data';
    $criteriaClass = 'text-muted';
    }
    @endphp

    <div class="mt-4 p-4 border rounded" style="background-color: #f8f9fa;">
        <h5 class="mb-3">Interpretasi Hasil:</h5>
        <div class="d-flex align-items-center">
            <div class="me-4">
                <h4 class="mb-0 {{ $criteriaClass }}" style="font-weight: 700;">{{ $criteria }}</h4>
                <small class="text-muted">Kriteria</small>
            </div>
            <div class="vr me-4"></div>
            <div>
                <h5 class="mb-1">Skala Penilaian:</h5>
                <ul class="mb-0" style="list-style-type: none; padding-left: 0;">
                    <li>4.51 - 5.00 = <span class="text-success">Sangat Baik</span></li>
                    <li>3.51 - 4.50 = <span class="text-primary">Baik</span></li>
                    <li>2.51 - 3.50 = <span class="text-warning">Cukup</span></li>
                    <li>1.00 - 2.50 = <span class="text-danger">Kurang</span></li>
                </ul>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection