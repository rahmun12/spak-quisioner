<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuestionnaireAnswer;
use App\Models\FormUser;

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
        $request->validate([
            'answers' => 'required|array',
            'suggestion' => 'nullable|string|max:1000',
        ]);

        // Save the answers
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

        
        return redirect()
            ->route('data.form')
            ->with('success', 'Terima kasih telah mengisi kuisioner!');
    }

    
    public function showSubmissions()
    {
        
        $submissions = FormUser::with(['answers.question', 'answers.selectedOption', 'personalData'])
            ->has('answers') 
            ->get();

        return view('admin.submissions', compact('submissions'));
    }
}
