<?php

use App\Http\Controllers\FormUserController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\QuestionnaireController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

Route::get('/data-diri', [FormUserController::class, 'showForm'])->name('data.form');
Route::post('/data-diri', [FormUserController::class, 'store'])->name('data.store');

// Tampilkan form kuisioner untuk user tertentu
Route::get('/kuisioner/{id}', [QuestionnaireController::class, 'showForm'])->name('kuisioner.form');

// Proses submit kuisioner
Route::post('/kuisioner/{id}', [QuestionnaireController::class, 'submit'])->name('kuisioner.submit');
