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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil materi yang dibuat oleh guru yang sedang login
        $materis = Materi::where('guru_id', Auth::id())->with('kelas.jurusan')->orderBy('created_at', 'desc')->paginate(10);
        return view('guru.materi.index', compact('materis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::with('jurusan')->get();
        return view('guru.materi.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kelas_id' => 'required|exists:kelas,id',
            'tipe' => 'required|in:pdf,video',
            'file_pdf' => 'required_if:tipe,pdf|file|mimes:pdf|max:10240', // max 10MB
            'youtube_url' => 'required_if:tipe,video|url'
        ]);

        $data = $request->only(['judul', 'deskripsi', 'kelas_id', 'tipe', 'youtube_url']);
        $data['guru_id'] = Auth::id();

        if ($request->tipe == 'pdf' && $request->hasFile('file_pdf')) {
            $path = $request->file('file_pdf')->store('public/materi_pdf');
            $data['file_path'] = $path;
        }

        Materi::create($data);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materi $materi)
    {
        // Pastikan guru hanya bisa mengedit materinya sendiri
        if ($materi->guru_id !== Auth::id()) {
            abort(403);
        }
        $kelas = Kelas::with('jurusan')->get();
        return view('guru.materi.edit', compact('materi', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materi $materi)
    {
        if ($materi->guru_id !== Auth::id()) {
            abort(403);
        }

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
                Storage::delete($materi->file_path);
            }
            $path = $request->file('file_pdf')->store('public/materi_pdf');
            $data['file_path'] = $path;
            $data['youtube_url'] = null; // Kosongkan youtube url jika tipe pdf
        } elseif ($request->tipe == 'video') {
             // Hapus file lama jika ada
            if ($materi->file_path) {
                Storage::delete($materi->file_path);
            }
            $data['file_path'] = null; // Kosongkan file path jika tipe video
        }


        $materi->update($data);

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materi $materi)
    {
        if ($materi->guru_id !== Auth::id()) {
            abort(403);
        }

        // Hapus file dari storage jika ada
        if ($materi->file_path) {
            Storage::delete($materi->file_path);
        }

        $materi->delete();

        return redirect()->route('guru.materi.index')->with('success', 'Materi berhasil dihapus.');
    }
}
