<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

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

// Route Dashboard Umum (untuk Guru dan Siswa)
Route::get('/dashboard', function () {
    // Nanti kita akan tambahkan logika untuk membedakan guru dan siswa di sini
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route untuk Profile User (Bawaan Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Grup Route Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    // Nanti semua route admin lainnya akan kita tambahkan di dalam grup ini
});


// Route Autentikasi (Bawaan Breeze)
require __DIR__.'/auth.php';