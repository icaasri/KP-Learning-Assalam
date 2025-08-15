<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Baris ini akan mencoba mengautentikasi user berdasarkan input
        $request->authenticate();

        // Baris ini akan membuat session baru untuk user
        $request->session()->regenerate();

        // --- INI BAGIAN YANG DIMODIFIKASI ---
        
        // Dapatkan user yang sedang login
        $user = $request->user();

        // Periksa apakah peran user adalah 'admin'
        if ($user->role === 'admin') {
            // Jika ya, arahkan ke dashboard admin
            return redirect()->intended(route('admin.dashboard'));
        }

        // Jika bukan admin (guru atau siswa), arahkan ke dashboard umum
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
