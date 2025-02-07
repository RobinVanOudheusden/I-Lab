<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizCodeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/teacher/login', function () {
    return view('teacher.login');
});

Route::get('/admin/login', function () {
    return view('admin.login');
});

Route::get('/join-quiz', function () {
    return view('quiz.join');
});

Route::post('/check-code', [QuizCodeController::class, 'checkCode'])->name('check-code');

require __DIR__.'/auth.php';
