@extends('layouts.admin')

@section('content')
<style>
    .data-card {
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #fff;
        overflow: hidden;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .data-card-header {
        background-color: #005EB8;
        color: #fff;
        padding: 10px 15px;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .data-card-body {
        padding: 15px;
        overflow-x: auto;
    }

    .answer-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .answer-table th,
    .answer-table td {
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        text-align: center;
    }

    .answer-table th {
        background-color: #f8f9fa;
        color: #005EB8;
        white-space: nowrap;
    }

    .answer-value {
        font-weight: bold;
        color: #005EB8;
        font-size: 0.9rem;
    }

    .question-number {
        min-width: 40px;
    }

    .no-answers {
        text-align: center;
        padding: 20px;
        color: #6c757d;
        font-style: italic;
    }

    .pagination {
        justify-content: center;
        margin-top: 20px;
    }

    .page-link {
        color: #005EB8;
        border: 1px solid #dee2e6;
        margin: 0 2px;
    }

    .page-item.active .page-link {
        background-color: #005EB8;
        border-color: #005EB8;
    }

    .page-link:hover {
        color: #003366;
        background-color: #e9ecef;
    }

    .filter-card {
        margin-bottom: 20px;
    }

    .filter-card .card-header {
        background-color: #005EB8;
        color: white;
        font-weight: 600;
    }

    .form-label {
        color: #005EB8;
        font-weight: 500;
    }
</style>

<div class="container mt-4">
    <h2 class="text-center mb-4">Data Jawaban Kuisioner (Nilai)</h2>

    <!-- Filter Card -->
    <div class="card filter-card mb-4">
        <div class="card-header">
            <i class="fas fa-filter me-2"></i>Filter Data
        </div>
        <div class="card-body">
            <form action="{{ route('admin.answers') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="start_date" class="form-label">Dari Tanggal</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label for="end_date" class="form-label">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate ?? '' }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.answers') }}" class="btn btn-secondary">
                        <i class="fas fa-sync-alt me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if($users->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i> Tidak ada data yang ditemukan untuk filter yang dipilih.
    </div>
    @else
    @php $counter = ($users->currentPage() - 1) * $users->perPage() + 1; @endphp
    @foreach($users as $user)
    <div class="data-card">
        <div class="data-card-header">
            <span>No: {{ $counter++ }} - Tanggal: {{ $user->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="data-card-body">
            @if($user->questionnaireAnswers->isEmpty())
            <div class="no-answers">
                <i class="fas fa-info-circle me-2"></i> Pengguna ini belum mengisi kuisioner.
            </div>
            @else
            <div class="table-responsive">
                <table class="answer-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            @foreach($questions as $question)
                            <th>{{ $loop->iteration }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Nilai</strong></td>
                            @php
                            // Group answers by question ID for easier access
                            $answersByQuestion = $user->questionnaireAnswers->keyBy('question_id');
                            @endphp
                            @foreach($questions as $question)
                            <td class="answer-value">
                                @if(isset($answersByQuestion[$question->id]))
                                @php
                                $answerText = $answersByQuestion[$question->id]->selectedOption->option_text;
                                $value = $answerValues[$answerText] ?? '-';
                                @endphp
                                {{ $value }}
                                @else
                                -
                                @endif
                            </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
    @endforeach

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->appends(request()->except('page'))->links() }}
    </div>
    @endif
</div>

@endsection