@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #F2F5F7;
        font-family: 'Roboto', sans-serif;
    }


    .form-container {
        width: 100%;
        max-width: 850px;
        margin: 50px auto;
        background-color: #fff;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        animation: fadeIn 0.5s ease-in-out;
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
        color: #000;
        margin-bottom: 30px;
        font-size: 1.5rem;
    }


    .question-text {
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .form-check-label {
        font-size: 0.95rem;
        color: #444;
    }


    textarea.form-control {
        border-radius: 10px;
        border: 1px solid #ccc;
        padding: 10px 14px;
        transition: all 0.3s ease;
    }

    textarea.form-control:focus {
        border-color: #005EB8;
        box-shadow: 0 0 0 0.2rem rgba(0, 94, 184, 0.15);
    }


    .btn-primary {
        background-color: #005EB8;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 28px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-primary:hover {
        background-color: #004b94;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 94, 184, 0.25);
    }


    .alert-success {
        background-color: #e6f7ff;
        border-left: 5px solid #005EB8;
        color: #005EB8;
        padding: 12px 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }


    .form-check-input {
        width: 18px;
        height: 18px;
        border: 2px solid #005EB8;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .form-check-input:checked {
        background-color: #005EB8;
        border-color: #005EB8;
        box-shadow: 0 0 0 3px rgba(0, 94, 184, 0.2);
    }

    .form-check-input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 94, 184, 0.25);
    }

    .form-check-label {
        margin-left: 8px;
        font-size: 1rem;
        color: #333;
        cursor: pointer;
    }
</style>

<div class="form-container">
    <h2 class="form-title">Form Kuisioner</h2>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('kuisioner.submit', $formUserId) }}" method="POST">
        @csrf

        @forelse ($questions as $index => $question)
        <div class="mb-4">
            <p class="question-text">{{ $index + 1 }}. {{ $question->text }}</p>

            @foreach ($question->options as $option)
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                    value="{{ $option->id }}" id="option_{{ $option->id }}" required>
                <label class="form-check-label" for="option_{{ $option->id }}">
                    {{ $option->option_text }}
                </label>
            </div>
            @endforeach
        </div>
        @empty
        <p class="text-muted">Tidak ada pertanyaan tersedia.</p>
        @endforelse

        <div class="mb-4">
            <label for="suggestion" class="form-label fw-bold">Saran dan Keluhan</label>
            <textarea class="form-control" id="suggestion" name="suggestion" rows="3"
                placeholder="Masukkan saran dan keluhan Anda (opsional)"></textarea>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
        </div>
    </form>
</div>
@endsection