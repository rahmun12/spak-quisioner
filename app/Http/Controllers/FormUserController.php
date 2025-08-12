<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormUser;
use App\Models\PersonalData;
use Illuminate\Support\Str;

class FormUserController extends Controller
{
    public function showForm()
    {
        return view('form.data_diri');
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'age' => 'required|string|max:10',
            'address' => 'required|string',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'phone_number' => 'required|string|max:20',
            'education' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'service_type' => 'required|string|in:PBB,Pajak Hotel,Pajak Parkir,Pajak Restoran',
        ]);

        
        $validated['token'] = Str::random(30);

        
        $formUser = FormUser::create($validated);
        PersonalData::create([
            'form_user_id' => $formUser->id,
            'full_name' => $validated['full_name'],
            'age' => $validated['age'],
            'address' => $validated['address'],
            'gender' => $validated['gender'],
            'phone_number' => $validated['phone_number'],
            'education' => $validated['education'],
            'occupation' => $validated['occupation'],
            'service_type' => $validated['service_type'],
        ]);

        
        $request->session()->regenerate();

        return redirect()->route('kuisioner.form', $formUser->id)
            ->with('success', 'Data diri berhasil disimpan. Silakan isi kuesioner berikutnya.');
    }
}
