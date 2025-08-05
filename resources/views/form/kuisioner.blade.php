@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #F2F5F7;
        font-family: 'Roboto', sans-serif;
    }

    .kuisioner-container {
        max-width: 750px;
        margin: 50px auto;
        background-color: #ffffff;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        animation: fadeIn 0.6s ease-in-out;
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

    .kuisioner-title {
        text-align: center;
        font-weight: 700;
        color: #005EB8;
        margin-bottom: 30px;
    }

    .form-check-input {
        border-color: #ccc;
        transition: all 0.3s ease;
        margin-top: 6px;
    }

    .form-check-input:checked {
        background-color: #005EB8;
        border-color: #005EB8;
    }

    .form-check-label {
        margin-left: 6px;
        font-weight: 500;
        color: #333;
    }

    .question-block {
        margin-bottom: 30px;
        padding: 20px;
        border-radius: 12px;
        background-color: #f9fbfd;
        border-left: 5px solid #87CEEB;
        transition: background-color 0.3s;
    }

    .question-block:hover {
        background-color: #eef5fb;
    }

    .btn-success {
        background-color: #005EB8;
        border: none;
        border-radius: 14px;
        font-weight: 600;
        padding: 10px 30px;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
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

<div class="kuisioner-container">
    <h2 class="kuisioner-title">Form Kuisioner</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('kuisioner.submit', $formUserId) }}" method="POST">
        @csrf

        @forelse ($questions as $index => $question)
            <div class="question-block">
                <p class="fw-bold mb-2">{{ $index + 1 }}. {{ $question->text }}</p>

                @foreach ($question->options as $option)
                    <div class="form-check mb-2">
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

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-success">Kirim Jawaban</button>
        </div>
    </form>
</div>
@endsection
