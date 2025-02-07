<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizCodeController;
use App\Http\Controllers\QuizController;

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
    return view('auth.teacher.login');
});

Route::get('/admin/login', function () {
    return view('admin.login');
});

Route::get('/join-quiz', function () {
    return view('quiz.join');
});

Route::post('/check-code', [QuizCodeController::class, 'checkCode'])->name('check-code');

Route::get('/create-quiz', function () {
    return view('quiz.create');
});

Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');

Route::post('/quiz', [QuizController::class, 'store'])->name('quiz.store');

Route::get('/quiz/{id}/edit', [QuizController::class, 'edit'])->name('quiz.edit');  

Route::put('/quiz/{id}', [QuizController::class, 'update'])->name('quiz.update');


require __DIR__.'/auth.php';
