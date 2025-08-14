@extends('layouts.admin')

@section('content')
<style>
    .table {
        border: 1px solid #dee2e6;
    }

    .table th,
    .table td {
        border: 1px solid #dee2e6;
        vertical-align: middle;
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
    }

    body {
        background-color: #f5f6f8;
    }

    h2 {
        color: #005EB8;
        font-weight: 700;
        margin-bottom: 25px;
    }

    .table-container {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        margin-bottom: 0;
    }

    .table th {
        background-color: #005EB8;
        color: white;
        font-weight: 600;
        white-space: nowrap;
        vertical-align: middle;
    }

    .table td {
        vertical-align: middle;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 94, 184, 0.05);
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 94, 184, 0.1);
    }

    .btn-delete {
        padding: 4px 8px;
        font-size: 0.85rem;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table td {
        padding: 6px 4px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: top;
    }

    .data-table td:first-child {
        font-weight: 600;
        color: #005EB8;
        width: 180px;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 4px 10px;
        font-size: 0.85rem;
        border-radius: 4px;
    }

    .btn-delete:hover {
        background-color: #b02a37;
    }

    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .card-header {
        border-radius: 8px 8px 0 0 !important;
        font-weight: 600;
    }

    .form-label {
        font-weight: 500;
        color: #005EB8;
    }

    .btn i {
        margin-right: 5px;
    }

    p.text-muted {
        font-style: italic;
        color: #777;
        margin: 0;
    }

    /* Modal style */
    .modal-header {
        background-color: #005EB8;
        color: white;
        border-bottom: none;
    }

    .modal-footer .btn-cancel {
        background-color: #87CEEB;
        color: #005EB8;
        font-weight: 600;
        border: none;
    }

    .modal-footer .btn-cancel:hover {
        background-color: #6bbce0;
    }
</style>

<div class="container mt-4">
    <h2 class="text-center">Data & Jawaban Kuisioner</h2>

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-filter me-2"></i>Filter Data
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users') }}" method="GET" class="row g-3">
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
                    <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                        <i class="fas fa-sync-alt me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($users->isEmpty())
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i> Tidak ada data yang ditemukan untuk filter yang dipilih.
    </div>
    @else
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Alamat</th>
                        <th>Umur</th>
                        <th>Jenis Kelamin</th>
                        <th>No HP</th>
                        <th>Pendidikan</th>
                        <th>Pekerjaan</th>
                        <th>Jenis Layanan</th>
                        @foreach($questions as $question)
                        <th class="text-center small">
                            <div class="fw-bold">{{ $question->text }}</div>
                        </th>
                        @endforeach
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    // Calculate the starting number for the current page
                    $counter = ($users->currentPage() - 1) * $users->perPage() + 1;
                    @endphp
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $counter++ }}</td>
                        <td>{{ $user->personalData ? $user->personalData->full_name : 'Tanpa Nama' }}</td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>{{ $user->personalData->address ?? '-' }}</td>
                        <td>{{ $user->personalData->age ?? '-' }}</td>
                        <td>{{ $user->personalData->gender ?? '-' }}</td>
                        <td>{{ $user->personalData->phone_number ?? '-' }}</td>
                        <td>{{ $user->personalData->education ?? '-' }}</td>
                        <td>{{ $user->personalData->occupation ?? '-' }}</td>
                        <td>{{ $user->personalData->service_type ?? '-' }}</td>

                        @php
                        // Group answers by question ID for easier access
                        $answersByQuestionId = [];
                        foreach ($user->questionnaireAnswers as $answer) {
                        if ($answer->question) {
                        $answersByQuestionId[$answer->question->id] = $answer->selectedOption->option_text;
                        }
                        }
                        @endphp

                        @foreach($questions as $question)
                        @php
                        $userAnswer = $answersByQuestionId[$question->id] ?? null;
                        @endphp
                        <td class="text-center">
                            {{ $userAnswer ?? '-' }}
                        </td>
                        @endforeach

                        <td>
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-3">
            {{ $users->appends(request()->except('page'))->links() }}
        </div>
    </div>
    @endif

    <!-- Modal Konfirmasi Hapus -->
    @foreach ($users as $user)
    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel{{ $user->id }}">Konfirmasi Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus <strong>{{ $user->personalData ? $user->personalData->full_name : 'User ini' }}</strong>?<br>
                    <span class="text-danger">Tindakan ini tidak dapat dibatalkan.</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
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
</style>
@endsection