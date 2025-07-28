@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Form Data Diri</h2>

    {{-- Tampilkan pesan sukses kalau ada --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('data.store') }}">
        @csrf
        <input type="text" name="full_name" placeholder="Nama Lengkap" required>
        <textarea name="address" placeholder="Alamat" required></textarea>
        <input type="date" name="birth_date" required>
        <input type="text" name="service_type" placeholder="Jenis Layanan" required>
        <input type="text" name="phone_number" placeholder="No HP" required>
        <input type="text" name="gender" placeholder="Jenis Kelamin" required>
        <input type="text" name="education" placeholder="Pendidikan" required>
        <input type="text" name="occupation" placeholder="Pekerjaan" required>

        <button type="submit">Lanjut ke Kuisioner</button>
    </form>
</div>
@endsection
