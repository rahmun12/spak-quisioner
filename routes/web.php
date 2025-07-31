<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AdminRegisterController;
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

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    // Registration Routes
    Route::get('/register', [AdminRegisterController::class, 'showRegistrationForm'])
        ->name('admin.register.form')
        ->middleware('guest:admin');
    
    Route::post('/register', [AdminRegisterController::class, 'register'])
        ->name('admin.register');

    // Login Routes
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])
        ->name('admin.login')
        ->middleware('guest:admin');

    Route::post('/login', [AdminAuthController::class, 'login'])
        ->name('admin.login.submit');

    // Protected Admin Routes
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])
            ->name('admin.logout');

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('/users', [AdminController::class, 'index'])
            ->name('admin.users');
    });
});