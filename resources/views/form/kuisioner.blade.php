@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Form Kuisioner</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('kuisioner.submit', ['id' => $formUserId]) }}" method="POST">
        @csrf

        <h4>Kuisioner</h4>

        @forelse($questions as $question)
        <div class="mb-4">
            <p><strong>{{ $loop->iteration }}. {{ $question->text }}</strong></p>

            @if($question->options->count())
            @foreach($question->options as $option)
            <div>
                <label>
                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" required>
                    {{ $option->option_text }}
                </label>
            </div>
            @endforeach
            @else
            <p class="text-danger">Tidak ada pilihan jawaban untuk pertanyaan ini.</p>
            @endif
        </div>
        @empty
        <p class="text-warning">Tidak ada pertanyaan tersedia.</p>
        @endforelse

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>
@endsection