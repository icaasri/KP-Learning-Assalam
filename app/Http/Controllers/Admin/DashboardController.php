<?php

namespace App\Http\Controllers\Admin; // <-- Ini bagian yang penting

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Pastikan ini ada

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk admin.
     */
    public function index()
    {
        // Mengambil data statistik untuk ditampilkan di dashboard
        $jumlahSiswa = User::where('role', 'siswa')->count();
        $jumlahGuru = User::where('role', 'guru')->count();
        
        // Mengirim data ke view
        return view('admin.dashboard', [
            'jumlahSiswa' => $jumlahSiswa,
            'jumlahGuru' => $jumlahGuru,
        ]);
    }
}
