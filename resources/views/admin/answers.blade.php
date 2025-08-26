@extends('layouts.admin')

@section('content')
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

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
            font-weight: 700;
            color: #000;
            margin-bottom: 40px;
            text-align: center;
            letter-spacing: 0.5px;
        }

        .alert-custom {
            background-color: #f0f8ff;
            border: 1px solid #b6daff;
            color: #005EB8;
            border-radius: 8px;
            padding: 14px;
            font-weight: 500;
        }
    </style>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title mb-0">Data Jawaban Kuisioner (Nilai)</h2>
            <form action="{{ route('admin.answers') }}" method="GET" class="d-inline">
                @if(request('start_date'))
                    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                @endif
                @if(request('end_date'))
                    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                @endif
                <input type="hidden" name="export" value="excel">
                <button type="submit" class="btn btn-success btn-sm shadow-sm">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </button>
            </form>
        </div>

        @if ($users->isEmpty())
            <div class="alert-custom text-center">
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
                            @foreach ($questions as $question)
                                <th>{{ $loop->iteration }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php $counter = 1 + (($users->currentPage() - 1) * $users->perPage()); @endphp
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $counter++ }}</td>
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
                </table>
            </div>


            <div class="mt-4">
                {{ $users->appends(request()->except('page'))->links() }}
            </div>
        @endif
    </div>
@endsection
