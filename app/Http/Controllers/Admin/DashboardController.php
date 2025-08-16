<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * Arahkan pengguna ke dashboard yang sesuai berdasarkan peran (role) mereka.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'guru') {
            // Diarahkan ke halaman materi guru sebagai dashboard defaultnya
            return redirect()->route('guru.materi.index');
        }

        if ($user->role === 'siswa') {
            // Diarahkan ke halaman materi siswa sebagai dashboard defaultnya
            return redirect()->route('siswa.materi.index');
        }

        // Fallback jika role tidak terdefinisi (seharusnya tidak terjadi)
        return view('dashboard');
    }
}
