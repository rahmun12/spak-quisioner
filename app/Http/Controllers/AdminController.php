<?php

namespace App\Http\Controllers;

use App\Models\FormUser;

class AdminController extends Controller
{
    public function index()
    {
        
        $users = FormUser::with(['personalData', 'questionnaireAnswers.question', 'questionnaireAnswers.selectedOption'])->get();
        return view('admin.users', compact('users'));
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
