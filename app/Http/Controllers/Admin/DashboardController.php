<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Tambahkan ini untuk mengambil data user

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk admin.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil data statistik untuk ditampilkan di dashboard
        $jumlahSiswa = User::where('role', 'siswa')->count();
        $jumlahGuru = User::where('role', 'guru')->count();
        // $jumlahMateri = Materi::count(); // Ini bisa ditambahkan nanti setelah model Materi dibuat

        // Mengirim data ke view
        return view('admin.dashboard', [
            'jumlahSiswa' => $jumlahSiswa,
            'jumlahGuru' => $jumlahGuru,
            // 'jumlahMateri' => $jumlahMateri,
        ]);
    }
}
