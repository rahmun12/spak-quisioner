@extends('layouts.admin')

@section('content')
<style>
    body {
        background-color: #f5f6f8;
    }

    h2 {
        color: #005EB8;
        font-weight: 700;
        margin-bottom: 25px;
    }

    .data-card {
        border: 1px solid #ddd;
        border-radius: 6px;
        background-color: #fff;
        overflow: hidden;
        margin-bottom: 20px;
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
        padding: 0;
    }

    .data-section {
        padding: 15px;
        border-bottom: 1px solid #e6e6e6;
    }

    .data-section:last-child {
        border-bottom: none;
    }

    .data-title {
        font-size: 1rem;
        font-weight: 600;
        color: #005EB8;
        margin-bottom: 8px;
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

    @foreach ($users as $user)
    <div class="data-card">
        <div class="data-card-header">
            <span>{{ $user->personalData ? $user->personalData->full_name : 'Tanpa Nama' }} - {{ $user->created_at->format('d/m/Y') }}</span>
            <button type="button" class="btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </div>

        <div class="data-card-body">
            <div class="data-section">
                <div class="data-title">Data Diri</div>
                @if ($user->personalData)
                <table class="data-table">
                    <tr><td>Alamat</td><td>{{ $user->personalData->address }}</td></tr>
                    <tr><td>Tanggal Lahir</td><td>{{ $user->personalData->birth_date }}</td></tr>
                    <tr><td>Jenis Kelamin</td><td>{{ $user->personalData->gender }}</td></tr>
                    <tr><td>No HP</td><td>{{ $user->personalData->phone_number }}</td></tr>
                    <tr><td>Pendidikan</td><td>{{ $user->personalData->education }}</td></tr>
                    <tr><td>Pekerjaan</td><td>{{ $user->personalData->occupation }}</td></tr>
                    <tr><td>Jenis Layanan</td><td>{{ $user->personalData->service_type }}</td></tr>
                </table>
                @else
                <p class="text-muted">Data pribadi belum tersedia.</p>
                @endif
            </div>

            <div class="data-section">
                <div class="data-title">Jawaban Kuisioner</div>
                @forelse ($user->questionnaireAnswers as $answer)
                    <p>
                        <strong>{{ optional($answer->question)->text ?? '[Pertanyaan tidak ditemukan]' }}</strong><br>
                        Jawaban: {{ optional($answer->selectedOption)->option_text ?? '[Jawaban tidak ditemukan]' }}
                    </p>
                @empty
                    <p class="text-muted">Belum mengisi kuisioner.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
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
@endsection
