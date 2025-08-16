<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Guru\MateriController;
use App\Http\Controllers\Guru\QuizController;
use App\Http\Controllers\Guru\QuestionController;
use App\Http\Controllers\Siswa\MateriController as SiswaMateriController;
use App\Http\Controllers\Siswa\QuizController as SiswaQuizController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route Utama (Halaman Awal)
Route::get('/', function () {
    return view('welcome');
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
});

// Grup Route Guru
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::resource('materi', MateriController::class);
    Route::resource('quiz', QuizController::class);
    Route::post('quiz/{quiz}/questions', [QuestionController::class, 'store'])->name('quiz.questions.store');
});

// Grup Route Siswa
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    // Rute Materi Siswa
    Route::get('materi', [SiswaMateriController::class, 'index'])->name('materi.index');
    Route::get('materi/{materi}', [SiswaMateriController::class, 'show'])->name('materi.show');
    
    // Rute Quiz Siswa
    Route::get('quiz', [SiswaQuizController::class, 'index'])->name('quiz.index');
    Route::get('quiz/{quiz}', [SiswaQuizController::class, 'show'])->name('quiz.show');
    Route::post('quiz/{quiz}', [SiswaQuizController::class, 'store'])->name('quiz.store');
    Route::get('quiz/result/{attempt}', [SiswaQuizController::class, 'result'])->name('quiz.result');
});


// Route Autentikasi
require __DIR__.'/auth.php';
