@extends('layouts.admin')

@section('content')
<style>
   
    .table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        font-size: 0.9rem;
        box-shadow: 0 1px 6px rgba(0, 0, 0, 0.05);
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
        width: 180px;
    }

    .col-tanggal {
        width: 120px;
    }

    .col-aksi {
        width: 80px;
        text-align: center;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f8faff;
    }

    .table-hover tbody tr:hover {
        background-color: #eef6ff;
        transition: background 0.2s ease-in-out;
    }

   
    .btn-action {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        margin: auto;
        transition: all 0.2s ease-in-out;
        font-size: 0.95rem;
    }

    .btn-action:hover {
        background: #005EB8;
        border-color: #005EB8;
        transform: scale(1.05);
        color: #fff !important;
        
    }

   
    .dropdown-toggle::after {
        display: none;
    }

    .dropdown-menu {
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        font-size: 0.85rem;
        z-index: 2000;
    }

    .dropdown-item {
        padding: 8px 12px;
        border-radius: 6px;
        transition: background 0.2s ease-in-out;
    }

    .dropdown-item:hover {
        background: #eef6ff;
        color: #005EB8;
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
        color: #005EB8;
        background-color: #e9ecef;
    }

    
    .detail-table {
        font-size: 0.8rem;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        max-width: 750px;
        margin: auto;
    }

    .detail-table th {
        padding: 4px 6px;
        font-size: 0.8rem;
        font-weight: 600;
        text-align: left;
    }

    .detail-table td {
        padding: 4px 6px;
        vertical-align: middle;
    }

    .detail-table thead.table-primary th {
        background-color: #005EB8;
        color: #fff;
    }

    .detail-table thead.table-secondary th {
        background-color: #f1f3f5;
        color: #333;
    }

    .detail-table tbody tr:nth-of-type(odd) {
        background-color: #fafbfc;
    }

    .detail-table tbody tr:hover {
        background-color: #f2f9ff;
    }

     
    .btn-excel {
        background-color: #217346; /* hijau khas Excel */
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
</style>


<div class="container mt-4">
    <h2 class="text-center">Data & Jawaban Kuisioner</h2>
    <a href="{{ route('admin.users.export') }}" class="btn btn-excel btn-sm shadow-sm ms-2">
        <i class="fas fa-file-excel me-1"></i> Export Excel
    </a>

    
    <div class="mb-2 p-2">
        <form action="{{ route('admin.users') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" class="form-control form-control-sm shadow-sm border-primary"
                    id="date" name="date" value="{{ $date ?? '' }}">
            </div>
            <div class="col-md-3">
                <label for="service_type" class="form-label">Jenis Layanan</label>
                <select class="form-select form-select-sm shadow-sm border-primary" id="service_type" name="service_type">
                    <option value="">Semua Layanan</option>
                    <option value="PBB" {{ request('service_type') == 'PBB' ? 'selected' : '' }}>PBB (Pajak Bumi dan Bangunan)</option>
                    <option value="Pajak Hotel" {{ request('service_type') == 'Pajak Hotel' ? 'selected' : '' }}>Pajak Hotel</option>
                    <option value="Pajak Parkir" {{ request('service_type') == 'Pajak Parkir' ? 'selected' : '' }}>Pajak Parkir</option>
                    <option value="Pajak Restoran" {{ request('service_type') == 'Pajak Restoran' ? 'selected' : '' }}>Pajak Restoran</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary btn-sm shadow-sm me-2">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
                <a href="{{ route('admin.users') }}" class="btn btn-outline-primary btn-sm shadow-sm">
                    <i class="fas fa-sync-alt me-1"></i> Reset
                </a>
            </div>
        </form>
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
                        <th class="col-no">No</th>
                        <th class="col-nama">Nama</th>
                        <th class="col-tanggal">Tanggal</th>
                        <th class="col-aksi">Aksi</th>
                        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
                    </tr>
                </thead>
                <tbody>
                    @php $counter = 1 + (($users->currentPage() - 1) * $users->perPage()); @endphp
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $counter++ }}</td>
                        <td>{{ $user->personalData?->full_name ?? 'Tanpa Nama' }}</td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="#detailRow{{ $user->id }}"
                                    class="btn-action text-primary"
                                    data-bs-toggle="collapse" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn-action text-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $user->id }}"
                                    title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                   
                    <tr class="collapse bg-light" id="detailRow{{ $user->id }}">
                        <td colspan="4">
                            <div class="table-responsive my-2">
                                <table class="table table-bordered table-sm mb-2 detail-table">
                                    <thead class="table-primary">
                                        <tr>
                                            <th colspan="2">
                                                <i class="fas fa-user-circle me-2"></i> Detail Pengguna
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Alamat</strong></td>
                                            <td>{{ $user->personalData->address ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Umur</strong></td>
                                            <td>{{ $user->personalData->age ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jenis Kelamin</strong></td>
                                            <td>{{ $user->personalData->gender ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>No HP</strong></td>
                                            <td>{{ $user->personalData->phone_number ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pendidikan</strong></td>
                                            <td>{{ $user->personalData->education ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Pekerjaan</strong></td>
                                            <td>{{ $user->personalData->occupation ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Jenis Layanan</strong></td>
                                            <td>{{ $user->personalData->service_type ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-bordered table-sm detail-table">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th colspan="2">
                                                <i class="fas fa-clipboard-list me-2"></i> Jawaban Kuisioner
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $answersByQuestionId = [];
                                        foreach ($user->questionnaireAnswers as $answer) {
                                        if ($answer->question) {
                                        $answersByQuestionId[$answer->question->id] = $answer->selectedOption->option_text;
                                        }
                                        }
                                        @endphp
                                        @foreach($questions as $question)
                                        <tr>
                                            <td style="width: 40%;"><em>{{ $question->text }}</em></td>
                                            <td>{{ $answersByQuestionId[$question->id] ?? '-' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                @if($user->suggestion)
                                <table class="table table-bordered table-sm detail-table mt-3">
                                    <thead class="table-info">
                                        <tr>
                                            <th>
                                                <i class="fas fa-comment-dots me-2"></i> Saran dan Keluhan
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="bg-light">
                                                <div class="p-2">
                                                    {{ $user->suggestion }}
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

       
        <div class="p-3">
            {{ $users->appends(request()->except('page'))->links() }}
        </div>
    </div>
    @endif

    
    @foreach ($users as $user)
    <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus
                    <strong>{{ $user->personalData?->full_name ?? 'User ini' }}</strong>?<br>
                    <span class="text-danger">Tindakan ini tidak dapat dibatalkan.</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection