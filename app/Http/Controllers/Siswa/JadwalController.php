<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Menampilkan jadwal pelajaran untuk kelas siswa yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user->kelas_id) {
            return view('siswa.jadwal.index')->with('jadwals', collect());
        }

        // Ambil jadwal berdasarkan kelas siswa, kelompokkan berdasarkan hari
        $jadwals = Jadwal::where('kelas_id', $user->kelas_id)
                         ->with('guru')
                         ->orderBy('waktu_mulai')
                         ->get()
                         ->groupBy('hari'); // Mengelompokkan jadwal berdasarkan hari

        // Urutkan hari agar sesuai (Senin, Selasa, ...)
        $orderedDays = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $sortedJadwals = collect($orderedDays)->mapWithKeys(function ($day) use ($jadwals) {
            return [$day => $jadwals->get($day)];
        })->filter(); // Filter untuk menghilangkan hari yang kosong

        return view('siswa.jadwal.index', ['jadwals' => $sortedJadwals]);
    }
}