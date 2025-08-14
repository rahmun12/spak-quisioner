<?php

namespace App\Http\Controllers;

use App\Models\FormUser;

class AdminController extends Controller
{
    public function index()
    {
        $startDate = request('start_date');
        $endDate = request('end_date');
        
        $query = FormUser::with(['personalData', 'questionnaireAnswers.question', 'questionnaireAnswers.selectedOption']);
        
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        
        $users = $query->orderBy('created_at', 'asc')->paginate(10);
        $questions = \App\Models\Question::with('options')->orderBy('id')->get();
        
        return view('admin.users', compact('users', 'startDate', 'endDate', 'questions'));
    }

    public function answers()
    {
        $startDate = request('start_date');
        $endDate = request('end_date');
        
        $query = FormUser::with(['questionnaireAnswers.question', 'questionnaireAnswers.selectedOption']);
        
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }
        
        $users = $query->orderBy('created_at', 'asc')->paginate(10);
        
        
        $answerValues = [
            'Tidak Pernah' => 4,
            'Kadang-kadang' => 3,
            'Sering' => 2,
            'Selalu' => 1
        ];
        
       
        $questions = \App\Models\Question::orderBy('id')->get();
        
        return view('admin.answers', compact('users', 'startDate', 'endDate', 'answerValues', 'questions'));
    }
    
    public function destroy($id)
    {
        try {
            $user = FormUser::findOrFail($id);
            
            
            $user->personalData()->delete();
            $user->questionnaireAnswers()->delete();
            
            
            $user->delete();
            
            return redirect()->route('admin.users')
                ->with('success', 'Data pengguna berhasil dihapus');
                
        } catch (\Exception $e) {
            return redirect()->route('admin.users')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }
}
