<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuestionnaireAnswer;

class QuestionnaireController extends Controller
{
    /**
     * Tampilkan form kuisioner berdasarkan ID form user.
     */
    public function showForm($id)
    {
        // Ambil semua pertanyaan beserta opsi jawabannya
        $questions = Question::with('options')->get();

        // Kirim ke view dengan form_user_id
        return view('form.kuisioner', [
            'questions'   => $questions,
            'formUserId'  => $id,
        ]);
    }

    /**
     * Proses pengisian kuisioner oleh user.
     */
    public function submit(Request $request, $id)
    {
        // Validasi minimal ada satu jawaban dikirim
        $request->validate([
            'answers' => 'required|array',
        ]);

        // Simpan semua jawaban user
        foreach ($request->answers as $questionId => $answerId) {
            QuestionnaireAnswer::create([
                'form_user_id' => $id,
                'question_id'  => $questionId,
                'answer_id'    => $answerId,
            ]);
        }

        // Redirect ke halaman awal form dengan pesan sukses
        return redirect()
            ->route('data.form')
            ->with('success', 'Terima kasih telah mengisi kuisioner!');
    }
}
