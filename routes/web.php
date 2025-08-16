<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Guru\MateriController;

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

// Route Dashboard Umum (untuk Guru dan Siswa setelah login)
Route::get('/dashboard', function () {
    // Nanti kita akan tambahkan logika untuk membedakan dashboard guru dan siswa di sini
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk Profile User (Bawaan Breeze)
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
    // Route admin lainnya bisa ditambahkan di sini
});

// Grup Route Guru
Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    // Dashboard guru bisa diarahkan ke halaman materi
    Route::get('/dashboard', [MateriController::class, 'index'])->name('dashboard');
    Route::resource('materi', MateriController::class);
    // Route guru lainnya bisa ditambahkan di sini
});


// Route Autentikasi (Bawaan Breeze)
require __DIR__.'/auth.php';
