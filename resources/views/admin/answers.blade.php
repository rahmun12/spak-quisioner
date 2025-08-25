@extends('layouts.admin')

@section('content')
<style>
    /* Table Styles */
    .table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        font-size: 0.9rem;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
    }

    .table thead th {
        background-color: #005EB8;
        color: #fff;
        font-weight: 600;
        text-align: center;
        padding: 12px 10px;
        border: 1px solid #dee2e6;
    }

    .table tbody td {
        padding: 10px 12px;
        vertical-align: middle;
        border: 1px solid #dee2e6;
        text-align: center;
    }

    .col-no {
        width: 60px;
    }

    .col-nama {
        min-width: 200px;
        text-align: left !important;
        padding-left: 15px !important;
    }

    .col-tanggal {
        width: 150px;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8faff;
    }

    .table-hover tbody tr:hover {
        background-color: #eef6ff;
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

    /* Suggestion Section */
    .suggestion-box {
        background: #f8f9fa;
        border-left: 4px solid #005EB8;
        padding: 12px;
        border-radius: 6px;
        margin-top: 10px;
        font-size: 0.9rem;
        text-align: left;
    }

    .no-answers {
        text-align: center;
        padding: 25px;
        color: #6c757d;
        font-style: italic;
        background-color: #f8f9fa;
        border-radius: 6px;
    }
</style>

<div class="container mt-4">
    <h2 class="text-center mb-4 fw-bold text-primary">Data Jawaban Kuisioner (Nilai)</h2>

    @if($users->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle me-2"></i> Tidak ada data yang ditemukan untuk filter yang dipilih.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th class="col-nama">Nama</th>
                        <th class="col-tanggal">Tanggal</th>
                        @foreach($questions as $question)
                            <th>P{{ $loop->iteration }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php $counter = 1 + (($users->currentPage() - 1) * $users->perPage()); @endphp
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $counter++ }}</td>
                            <td class="col-nama">
                                {{ $user->name }}
                                @if($user->suggestion)
                                    <div class="suggestion-box mt-2">
                                        <strong>💬 Saran/Keluhan:</strong><br>
                                        {{ $user->suggestion }}
                                    </div>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            
                            @if($user->questionnaireAnswers->isEmpty())
                                <td colspan="{{ count($questions) }}" class="text-center">
                                    <span class="text-muted">Belum mengisi kuisioner</span>
                                </td>
                            @else
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
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->appends(request()->except('page'))->links() }}
        </div>
    @endif
</div>

@endsection
