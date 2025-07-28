<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormUser;
use Illuminate\Support\Str;

class FormUserController extends Controller
{
    public function showForm()
    {
        return view('form.data_diri');
    }

    public function store(Request $request)
{
    $data = $request->all();
    $data['token'] = Str::random(30); // generate token otomatis

    $formUser = FormUser::create($data);

    return redirect()->route('kuisioner.form', $formUser->id);
}
}
