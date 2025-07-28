<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\QuestionnaireAnswer;

class QuestionnaireController extends Controller
{
    
    public function showForm($id)
    {
       
        $questions = Question::with('options')->get();

        return view('form.kuisioner', [
            'questions' => $questions,
            'formUserId' => $id,
        ]);
    }

    
    public function submit(Request $request, $id)
    {
        
        $request->validate([
            'answers' => 'required|array',
        ]);

        foreach ($request->answers as $questionId => $answerId) {
            QuestionnaireAnswer::create([
                'form_user_id'     => $id,
                'question_id'      => $questionId,
                'answer_id'        => $answerId,
            ]);
        }

        return redirect()->route('data.form')->with('success', 'Terima kasih telah mengisi kuisioner!');
    }
}