<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\FormUser;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionnaireAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionnaireController extends Controller
{

    public function showForm($id)
    {

        $questions = Question::with('options')->get();

        return view('form.kuisioner', [
            'questions'   => $questions,
            'formUserId'  => $id,
        ]);
    }


    public function submit(Request $request, $id)
    {
        try {
            // Start database transaction
            DB::beginTransaction();

            $request->validate([
                'answers' => 'required|array',
                'suggestion' => 'nullable|string|max:1000',
            ]);

            // Save answers
            foreach ($request->answers as $questionId => $answerId) {
                QuestionnaireAnswer::create([
                    'form_user_id' => $id,
                    'question_id'  => $questionId,
                    'selected_option_id' => $answerId,
                ]);
            }

            // Save the suggestion if provided
            if ($request->filled('suggestion')) {
                $formUser = FormUser::findOrFail($id);
                $formUser->suggestion = $request->suggestion;
                $formUser->save();
            }

            // Commit transaction
            DB::commit();

            // Return success response
            return redirect()->route('landing')
                ->with('success', 'Terima kasih telah mengisi kuisioner!');
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            Log::error('Questionnaire submission error: ' . $e->getMessage(), [
                'exception' => $e,
                'form_user_id' => $id,
                'request_data' => $request->all()
            ]);

            return redirect()->route('landing')
                ->with('error', 'Terjadi kesalahan saat menyimpan jawaban. Silakan coba lagi.');
        }
    }


    public function showSubmissions()
    {

        $submissions = FormUser::with(['answers.question', 'answers.selectedOption', 'personalData'])
            ->has('answers')
            ->get();

        return view('admin.submissions', compact('submissions'));
    }
}
