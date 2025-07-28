@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow rounded">
        <div class="card-body p-4">
            <h2 class="text-center mb-4">Formulir Data Diri</h2>

            {{-- Tampilkan pesan sukses --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('data.store') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="full_name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="birth_date" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="phone_number" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="education" class="form-label">Pendidikan</label>
                        <input type="text" class="form-control" id="education" name="education" required>
                    </div>
                    <div class="col-md-6">
                        <label for="occupation" class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" id="occupation" name="occupation" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="service_type" class="form-label">Jenis Layanan yang Diterima</label>
                    <select class="form-select" id="service_type" name="service_type" required>
                        <option value="">Pilih Jenis Layanan</option>
                        <option value="PBB">PBB (Pajak Bumi dan Bangunan)</option>
                        <option value="Pajak Hotel">Pajak Hotel</option>
                        <option value="Pajak Parkir">Pajak Parkir</option>
                        <option value="Pajak Restoran">Pajak Restoran</option>
                    </select>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">Lanjut ke Kuisioner</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
