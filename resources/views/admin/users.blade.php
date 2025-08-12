@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center">Data User & Jawaban Kuisioner</h2>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @foreach ($users as $user)
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <div>
                {{ $user->personalData ? $user->personalData->full_name : 'Tanpa Nama' }} - {{ $user->created_at->format('d/m/Y') }}
            </div>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
        <div class="card-body">
            <h5 class="card-title">Data Diri</h5>

            @if ($user->personalData)
            <ul class="list-group mb-3">
                <li class="list-group-item"><strong>Alamat:</strong> {{ $user->personalData->address }}</li>
                <li class="list-group-item"><strong>Tanggal Lahir:</strong> {{ $user->personalData->birth_date }}</li>
                <li class="list-group-item"><strong>Jenis Kelamin:</strong> {{ $user->personalData->gender }}</li>
                <li class="list-group-item"><strong>No HP:</strong> {{ $user->personalData->phone_number }}</li>
                <li class="list-group-item"><strong>Pendidikan:</strong> {{ $user->personalData->education }}</li>
                <li class="list-group-item"><strong>Pekerjaan:</strong> {{ $user->personalData->occupation }}</li>
                <li class="list-group-item"><strong>Jenis Layanan:</strong> {{ $user->personalData->service_type }}</li>
            </ul>
            @else
            <p class="text-muted">Data pribadi belum tersedia.</p>
            @endif

            <h5 class="card-title mt-4">Jawaban Kuisioner</h5>
            @forelse ($user->questionnaireAnswers as $answer)
            <!-- {{ $answer }} -->
            <p>
                <strong>{{ optional($answer->question)->text ?? '[Pertanyaan tidak ditemukan]' }}</strong><br>
                Jawaban: {{ optional($answer->selectedOption)->option_text ?? '[Jawaban tidak ditemukan]' }}
            </p>
            @empty
            <p class="text-muted">Belum mengisi kuisioner.</p>
            @endforelse
        </div>
    </div>
    @endforeach
</div>
@endsection