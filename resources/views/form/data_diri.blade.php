@extends('layouts.app')

@section('content')
<style>
   body {
    background-color: #F2F5F7;
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
}


.hero {
    background: url('/images/tugu-malang-bg.jpg') center/cover no-repeat;
    position: relative;
    padding: 100px 20px 150px;
    color: white;
    text-align: center;
    width: 100%; 
}


.form-container {
    width: 100%;
    max-width: 100%; 
    margin: 50px auto 50px;
    background-color: rgba(255, 255, 255, 0.95);
    padding: 40px;
    border-radius: 0; 
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
}

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-title {
        text-align: center;
        font-weight: 700;
        color: #005EB8;
        margin-bottom: 30px;
    }

    .form-label {
        font-weight: 500;
        color: #333;
    }

    .form-control,
    .form-select {
        border-radius: 12px;
        border: 1px solid #ccc;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #005EB8;
        box-shadow: 0 0 0 0.2rem rgba(0, 94, 184, 0.15);
    }

    .btn-primary {
        background-color: #005EB8;
        border: none;
        border-radius: 14px;
        font-weight: 600;
        padding: 10px 30px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #004b94;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 94, 184, 0.3);
    }

    .alert-success {
        background-color: #e6f7ff;
        border-left: 5px solid #87CEEB;
        color: #005EB8;
        padding: 12px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
</style>

<div class="form-container">
    <h2 class="form-title">Formulir Data Diri</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('data.store') }}">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="full_name" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="full_name" name="full_name" required>
            </div>
            <div class="col-md-6">
                <label for="age" class="form-label">Umur</label>
                <input type="text" class="form-control" id="age" name="age" required>
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
    <option value="" disabled selected hidden>Pilih Jenis Kelamin</option>
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
    <option value="" disabled selected>Pilih Jenis Layanan</option>
    <option value="PBB">PBB (Pajak Bumi dan Bangunan)</option>
    <option value="Pajak Hotel">Pajak Hotel</option>
    <option value="Pajak Parkir">Pajak Parkir</option>
    <option value="Pajak Restoran">Pajak Restoran</option>
</select>

        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Lanjut ke Kuisioner</button>
        </div>
    </form>
</div>
@endsection
