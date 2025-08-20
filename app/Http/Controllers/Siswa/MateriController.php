<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user->kelas_id) {
            return view('siswa.materi.index')->with('materis', collect());
        }
        $materis = Materi::where('kelas_id', $user->kelas_id)->with('guru')->orderBy('created_at', 'desc')->paginate(10);
        return view('siswa.materi.index', compact('materis'));
    }

    public function show(Materi $materi)
    {
        if (Auth::user()->kelas_id !== $materi->kelas_id) {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES KE MATERI INI');
        }
        if ($materi->tipe === 'video' && $materi->youtube_url) {
            $materi->youtube_url = $this->getEmbedUrl($materi->youtube_url);
        }
        return view('siswa.materi.show', compact('materi'));
    }

    public function viewPdf(Materi $materi)
    {
        if (Auth::user()->kelas_id !== $materi->kelas_id) {
            abort(403);
        }

        // PERBAIKAN: Gunakan Storage facade untuk mendapatkan path absolut
        $path = Storage::disk('public')->path($materi->file_path);

        // Keamanan: Pastikan file ada
        if (!Storage::disk('public')->exists($materi->file_path)) {
            abort(404, 'File not found');
        }

        // Ambil file dari storage dan tampilkan di browser
        return response()->file($path);
    }

    private function getEmbedUrl($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        $youtube_id = $match[1] ?? null;
        return $youtube_id ? 'https://www.youtube.com/embed/' . $youtube_id : null;
    }
}