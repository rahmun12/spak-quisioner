@extends('layouts.admin')

@section('content')
<style>
    .data-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #fff;
        overflow: hidden;
        margin-bottom: 25px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    }

    .data-card-header {
        background-color: #005EB8;
        color: #fff;
        padding: 12px 18px;
        font-weight: 600;
        font-size: 0.95rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .data-card-body {
        padding: 18px;
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
        padding: 8px 10px;
        text-align: center;
        font-size: 0.9rem;
    }

    .answer-table th {
        background-color: #f1f6fa;
        color: #005EB8;
        font-weight: 600;
        white-space: nowrap;
    }

    .answer-value {
        font-weight: 600;
        color: #005EB8;
    }

    .no-answers {
        text-align: center;
        padding: 25px;
        color: #6c757d;
        font-style: italic;
        background-color: #f8f9fa;
        border-radius: 6px;
    }

    .pagination {
        justify-content: center;
        margin-top: 25px;
    }

    .page-link {
        color: #005EB8;
        border: 1px solid #dee2e6;
        margin: 0 2px;
        border-radius: 6px;
        padding: 5px 10px;
    }

    .page-item.active .page-link {
        background-color: #005EB8;
        border-color: #005EB8;
    }

    .page-link:hover {
        color: #003366;
        background-color: #e9ecef;
    }

    /* Filter Card */
    .filter-card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 25px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .form-label {
        color: #005EB8;
        font-weight: 500;
        font-size: 0.9rem;
    }

    /* Suggestion Section */
    .suggestion-box {
        background: #f8f9fa;
        border-left: 4px solid #005EB8;
        padding: 12px;
        border-radius: 6px;
        margin-top: 10px;
        font-size: 0.9rem;
    }
</style>

<div class="container mt-4">
    <h2 class="text-center mb-4 fw-bold text-primary">Data Jawaban Kuisioner (Nilai)</h2>

  

    <!-- Data -->
    @if($users->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i> Tidak ada data yang ditemukan untuk filter yang dipilih.
        </div>
    @else
        @php $counter = ($users->currentPage() - 1) * $users->perPage() + 1; @endphp
        @foreach($users as $user)
            <div class="data-card-header d-flex justify-content-between">
    <div>Nama: {{ $user->name }}</div>
    <div>Tanggal: {{ $user->created_at->format('d/m/Y') }}</div>
</div>


                <div class="data-card-body">
                    @if($user->questionnaireAnswers->isEmpty())
                        <div class="no-answers">
                            <i class="fas fa-info-circle me-2"></i> Pengguna ini belum mengisi kuisioner.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="answer-table">
                                <tbody>
                                    <tr>
                                        @php
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

                    @if($user->suggestion)
                        <div class="mt-3 pt-2 border-top">
                            <h6 class="fw-bold text-primary">💬 Saran dan Keluhan:</h6>
                            <div class="suggestion-box">
                                {{ $user->suggestion }}
                            </div>
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
