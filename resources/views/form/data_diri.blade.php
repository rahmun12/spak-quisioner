@extends('layouts.app')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
@endpush

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #f6f9fc, #eef3f9);
            font-family: 'Roboto', sans-serif;
        }

        .form-container {
            width: 100%;
            max-width: 880px;
            margin: 60px auto;
            background-color: #fff;
            padding: 45px;
            border-radius: 16px;
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(25px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-title {
            text-align: center;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 35px;
            font-size: 1.8rem;
            position: relative;
        }


        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .form-control,
        .form-select,
        textarea {
            border-radius: 12px;
            border: 1px solid #ccc;
            padding: 12px 15px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus,
        .form-select:focus,
        textarea:focus {
            border-color: #005EB8;
            box-shadow: 0 0 8px rgba(0, 94, 184, 0.15);
        }

        textarea {
            resize: none;
        }

        .btn-primary {
            background: #005EB8;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            padding: 12px 32px;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-primary:hover {
            background-color: #004b94;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 94, 184, 0.25);
        }

        .alert-success {
            background-color: #e6f7ff;
            border-left: 5px solid #005EB8;
            color: #005EB8;
            padding: 14px 22px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.92rem;
        }
    </style>

    <div class="form-container">
        <h2 class="form-title">Formulir Data Diri</h2>

        @if (session('success'))
            <div class="d-none" id="success-message">{{ session('success') }}</div>
        @endif

        <form id="dataDiriForm" method="POST" action="{{ route('data.store') }}">
            @csrf

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="full_name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                </div>
                <div class="col-md-6">
                    <label for="age" class="form-label">Usia</label>
                    <select class="form-select" id="age" name="age" required>
                        <option value="" disabled selected hidden>Pilih Usia</option>
                        <option value="10-12">10 - 12 tahun</option>
                        <option value="13-17">13 - 17 tahun</option>
                        <option value="18-24">18 - 24 tahun</option>
                        <option value="25-39">25 - 39 tahun</option>
                        <option value="40-54">40 - 54 tahun</option>
                        <option value="55-69">55 - 69 tahun</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label for="address" class="form-label">Alamat</label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
            </div>

            <div class="row mb-4">
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
                    <input type="text" class="form-control" id="phone_number" name="phone_number" 
                           inputmode="numeric" 
                           pattern="[0-9]*" 
                           title="Harap masukkan nomor telepon yang valid (hanya angka)" 
                           oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                           required>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="education" class="form-label">Pendidikan</label>
                    <select class="form-select" id="education" name="education" required>
                        <option value="" disabled selected hidden>Pilih Pendidikan</option>
                        <option value="SD / Tidak Tamat">SD / Tidak Tamat</option>
                        <option value="SD / MI">SD / MI</option>
                        <option value="SMP / MTS">SMP / MTS</option>
                        <option value="SMA / SMK / MA">SMA / SMK / MA</option>
                        <option value="Diploma - D1/D2/D3">Diploma - D1/D2/D3</option>
                        <option value="Sarjana - D4/S1">Sarjana - D4/S1</option>
                        <option value="Magister - S2">Magister - S2</option>
                        <option value="Doktor - S3">Doktor - S3</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="occupation" class="form-label">Pekerjaan</label>
                    <select class="form-select" id="occupation" name="occupation" required>
                        <option value="" disabled selected hidden>Pilih Pekerjaan</option>
                        <option value="Pelajar">Pelajar</option>
                        <option value="Mahasiswa">Mahasiswa</option>
                        <option value="Pegawai Negeri / ASN (Selain Guru/Dosen)">Pegawai Negeri / ASN (Selain Guru/Dosen)</option>
                        <option value="Pegawai Swasta">Pegawai Swasta</option>
                        <option value="Pengusaha/Pedagang">Pengusaha/Pedagang</option>
                        <option value="Pegawai Honorer">Pegawai Honorer</option>
                        <option value="Pegawai BUMN">Pegawai BUMN</option>
                        <option value="Anggota TNI/POLRI">Anggota TNI/POLRI</option>
                        <option value="Dosen/Guru (Negeri/Swasta)">Dosen/Guru (Negeri/Swasta)</option>
                        <option value="Buruh (Pabrik, Penjaga Toko, Konstruksi, dll)">Buruh (Pabrik, Penjaga Toko, Konstruksi, dll)</option>
                        <option value="Petani/Nelayan">Petani/Nelayan</option>
                        <option value="Pengacara/Notaris/Dokter, dll">Pengacara/Notaris/Dokter, dll</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label for="service_type" class="form-label">Jenis Layanan yang Diterima</label>
                <select class="form-select" id="service_type" name="service_type" required>
                    <option value="" disabled selected hidden>Pilih Jenis Layanan</option>
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
