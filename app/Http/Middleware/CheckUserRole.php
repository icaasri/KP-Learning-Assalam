<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Periksa apakah user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Periksa apakah peran user diizinkan
        $user = Auth::user();
        foreach ($roles as $role) {
            if ($user->role == $role) {
                return $next($request);
            }
        }

        // Jika tidak diizinkan, kembalikan ke halaman yang sesuai atau tampilkan error
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses.');
    }
}