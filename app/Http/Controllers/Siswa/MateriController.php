<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    /**
     * Menampilkan daftar materi untuk kelas siswa yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Pastikan siswa memiliki kelas
        if (!$user->kelas_id) {
            // Tampilkan pesan jika siswa belum dimasukkan ke kelas manapun
            return view('siswa.materi.index')->with('materis', collect());
        }

        $materis = Materi::where('kelas_id', $user->kelas_id)
                         ->with('guru') // Ambil data guru untuk ditampilkan
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);

        return view('siswa.materi.index', compact('materis'));
    }

    /**
     * Menampilkan detail satu materi.
     */
    public function show(Materi $materi)
    {
        // Keamanan: Pastikan siswa hanya bisa melihat materi untuk kelasnya
        if (Auth::user()->kelas_id !== $materi->kelas_id) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE MATERI INI');
        }

        // Jika tipe video, ubah URL YouTube menjadi URL embed
        if ($materi->tipe === 'video' && $materi->youtube_url) {
            $materi->youtube_url = $this->getEmbedUrl($materi->youtube_url);
        }

        return view('siswa.materi.show', compact('materi'));
    }

    /**
     * Helper function untuk mengubah URL YouTube biasa menjadi URL embed.
     */
    private function getEmbedUrl($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        $youtube_id = $match[1] ?? null;
        return $youtube_id ? 'https://www.youtube.com/embed/' . $youtube_id : null;
    }
}
