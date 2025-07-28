@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body p-4">
            <h2 class="text-center mb-4">Form Kuisioner</h2>

            @if(session('success'))
            <div class="alert alert-success">{{ session('success!') }}</div>
            @endif

            <form action="{{ route('kuisioner.submit', $formUserId) }}" method="POST">

                @csrf

                @forelse ($questions as $index => $question)
                <div class="mb-4">
                    <p class="fw-bold">{{ $index + 1 }}. {{ $question->text }}</p>

                    @foreach ($question->options as $option)
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="answers[{{ $question->id }}]"
                            value="{{ $option->id }}"
                            id="option_{{ $option->id }}"
                            required>
                        <label class="form-check-label" for="option_{{ $option->id }}">
                            {{ $option->option_text }}
                        </label>
                    </div>
                    @endforeach
                </div>
                @empty
                <p class="text-muted">Tidak ada pertanyaan tersedia.</p>
                @endforelse

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Kirim Jawaban</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection