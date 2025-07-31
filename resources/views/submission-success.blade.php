@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Terima Kasih!</div>

                <div class="card-body text-center">
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Pengisian Kuisioner Berhasil!</h4>
                        <p>Terima kasih telah meluangkan waktu untuk mengisi kuisioner ini. Jawaban Anda sangat berharga bagi kami.</p>
                        <hr>
                        <p class="mb-0">Anda dapat menutup halaman ini.</p>
                    </div>
                    <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke Halaman Utama</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
