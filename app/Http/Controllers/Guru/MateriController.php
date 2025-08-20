<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Materi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function index()
    {
        $materis = Materi::where('guru_id', Auth::id())->with('kelas.jurusan')->orderBy('created_at', 'desc')->paginate(10);
        return view('guru.materi.index', compact('materis'));
    }

    public function create()
    {
        $kelas = Kelas::with('jurusan')->get();
        return view('guru.materi.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kelas_id' => 'required|exists:kelas,id',
            'tipe' => 'required|in:pdf,video',
            'file_pdf' => 'required_if:tipe,pdf|nullable|file|mimes:pdf|max:10240',
            'youtube_url' => 'required_if:tipe,video|nullable|url'
        ]);

        $data = $request->only(['judul', 'deskripsi', 'kelas_id', 'tipe', 'youtube_url']);
        $data['guru_id'] = Auth::id();

        if ($request->tipe == 'pdf' && $request->hasFile('file_pdf')) {
            // PERBAIKAN: Simpan ke disk 'public' di dalam folder 'materi_pdf'
            $path = $request->file('file_pdf')->store('materi_pdf', 'public');
            $data['file_path'] = $path; // Path yang disimpan sekarang: "materi_pdf/random_filename.pdf"
            $data['youtube_url'] = null;
        }

        Materi::create($data);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(Materi $materi)
    {
        if ($materi->guru_id !== Auth::id()) abort(403);
        $kelas = Kelas::with('jurusan')->get();
        return view('guru.materi.edit', compact('materi', 'kelas'));
    }

    public function update(Request $request, Materi $materi)
    {
        if ($materi->guru_id !== Auth::id()) abort(403);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kelas_id' => 'required|exists:kelas,id',
            'tipe' => 'required|in:pdf,video',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'youtube_url' => 'nullable|url'
        ]);

        $data = $request->only(['judul', 'deskripsi', 'kelas_id', 'tipe', 'youtube_url']);

        if ($request->tipe == 'pdf' && $request->hasFile('file_pdf')) {
            // Hapus file lama jika ada
            if ($materi->file_path) {
                Storage::disk('public')->delete($materi->file_path);
            }
            // PERBAIKAN: Simpan ke disk 'public'
            $path = $request->file('file_pdf')->store('materi_pdf', 'public');
            $data['file_path'] = $path;
            $data['youtube_url'] = null;
        } elseif ($request->tipe == 'video') {
             if ($materi->file_path) {
                Storage::disk('public')->delete($materi->file_path);
            }
            $data['file_path'] = null;
        }
        
        $materi->update($data);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        if ($materi->guru_id !== Auth::id()) abort(403);

        if ($materi->file_path) {
            Storage::disk('public')->delete($materi->file_path);
        }

        $materi->delete();

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil dihapus.');
    }
}