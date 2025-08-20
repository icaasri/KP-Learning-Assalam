<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * Method ini akan dipanggil secara otomatis setelah login berhasil
     * dan akan mengarahkan pengguna berdasarkan role mereka.
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'guru') {
            // Mengarahkan ke halaman materi guru sebagai default dashboard
            return redirect()->route('guru.materi.index');
        }

        if ($user->role === 'siswa') {
            // Mengarahkan ke halaman materi siswa sebagai default dashboard
            return redirect()->route('siswa.materi.index');
        }

        // Fallback jika user tidak punya role yang sesuai (seharusnya tidak terjadi)
        // Logout-kan user dan kembalikan ke halaman login dengan pesan error.
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('error', 'Anda tidak memiliki role yang valid untuk mengakses sistem.');
    }
}