<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Guru\MateriController;
use App\Http\Controllers\Guru\QuizController;
use App\Http\Controllers\Guru\QuestionController;
use App\Http\Controllers\Siswa\MateriController as SiswaMateriController;
use App\Http\Controllers\Siswa\QuizController as SiswaQuizController;
use App\Http\Controllers\Siswa\JadwalController as SiswaJadwalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route Utama (Halaman Awal)
Route::get('/', function () {
    return redirect()->route('login');
});

// Route Dashboard Utama (Akan diarahkan berdasarkan role)
Route::get('/dashboard', [DashboardController::class, '__invoke'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route untuk Profile User
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// =====================================================================
// GRUP ROUTE UNTUK SETIAP PERAN (ROLE)
// =====================================================================

// Grup Route Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('jadwal', JadwalController::class);
});

// Grup Route Guru
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::resource('materi', MateriController::class);
    Route::resource('quiz', QuizController::class);
    
    // --- PERBAIKAN NAMA ROUTE DI SINI ---
    Route::post('quiz/{quiz}/questions', [QuestionController::class, 'store'])->name('quiz.questions.store');
    Route::get('quiz/{quiz}/questions/{question}/edit', [QuestionController::class, 'edit'])->name('quiz.questions.edit');
    Route::put('quiz/{quiz}/questions/{question}', [QuestionController::class, 'update'])->name('quiz.questions.update');
    Route::delete('quiz/{quiz}/questions/{question}', [QuestionController::class, 'destroy'])->name('quiz.questions.destroy');
});

// Grup Route Siswa
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('materi', [SiswaMateriController::class, 'index'])->name('materi.index');
    Route::get('materi/{materi}', [SiswaMateriController::class, 'show'])->name('materi.show');
    Route::get('materi/{materi}/view-pdf', [SiswaMateriController::class, 'viewPdf'])->name('materi.viewPdf');
    Route::get('quiz', [SiswaQuizController::class, 'index'])->name('quiz.index');
    Route::get('quiz/{quiz}', [SiswaQuizController::class, 'show'])->name('quiz.show');
    Route::post('quiz/{quiz}', [SiswaQuizController::class, 'store'])->name('quiz.store');
    Route::get('quiz/result/{attempt}', [SiswaQuizController::class, 'result'])->name('quiz.result');
    Route::get('jadwal', [SiswaJadwalController::class, 'index'])->name('jadwal.index');
});


// Route Autentikasi
require __DIR__.'/auth.php';