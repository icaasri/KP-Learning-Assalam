<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user (guru dan siswa).
     */
    public function index()
    {
        // Ambil semua user kecuali admin, urutkan berdasarkan nama, dan gunakan pagination.
        $users = User::where('role', '!=', 'admin')->orderBy('name')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat user baru.
     */
    public function create()
    {
        // Ambil semua data kelas untuk ditampilkan di dropdown.
        $kelas = Kelas::orderBy('tingkat')->get();
        return view('admin.users.create', compact('kelas'));
    }

    /**
     * Menyimpan user baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form.
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:guru,siswa'],
            'kelas_id' => ['nullable', 'exists:kelas,id'], // Hanya wajib jika role adalah siswa.
        ]);

        // Buat user baru.
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            // Jika rolenya siswa, simpan kelas_id. Jika guru, biarkan null.
            'kelas_id' => $request->role === 'siswa' ? $request->kelas_id : null,
        ]);

        // Arahkan kembali ke halaman daftar user dengan pesan sukses.
        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data user.
     * Laravel secara otomatis akan mencari User berdasarkan {user} di URL.
     */
    public function edit(User $user)
    {
        $kelas = Kelas::orderBy('tingkat')->get();
        return view('admin.users.edit', compact('user', 'kelas'));
    }

    /**
     * Memperbarui data user di database.
     */
    public function update(Request $request, User $user)
    {
        // Validasi input, pastikan username dan email unik kecuali untuk user ini sendiri.
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:guru,siswa'],
            'kelas_id' => ['nullable', 'exists:kelas,id'],
        ]);

        // Update data user.
        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'kelas_id' => $request->role === 'siswa' ? $request->kelas_id : null,
        ]);

        // Jika admin mengisi kolom password, update juga passwordnya.
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Menghapus user dari database.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
