<?php

namespace App\Http\Controllers;

use App\Models\FormUser;

class AdminController extends Controller
{
    public function index()
    {
        // Ambil semua user beserta data pribadi dan jawaban kuisioner
        $users = FormUser::with(['personalData', 'questionnaireAnswers.question', 'questionnaireAnswers.selectedOption'])->get();
        return view('admin.users', compact('users'));
    }
}
