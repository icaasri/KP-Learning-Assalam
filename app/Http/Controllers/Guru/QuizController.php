<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::where('guru_id', Auth::id())->with('kelas.jurusan')->withCount('questions')->latest()->paginate(10);
        return view('guru.quiz.index', compact('quizzes'));
    }

    public function create()
    {
        $kelas = Kelas::with('jurusan')->get();
        return view('guru.quiz.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $quiz = Quiz::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'kelas_id' => $request->kelas_id,
            'guru_id' => Auth::id(),
        ]);

        return redirect()->route('guru.quiz.show', $quiz)->with('success', 'Quiz berhasil dibuat. Sekarang tambahkan pertanyaan.');
    }

    public function show(Quiz $quiz)
    {
        if ($quiz->guru_id !== Auth::id()) abort(403);
        
        $quiz->load('questions.answers');
        return view('guru.quiz.show', compact('quiz'));
    }

    // --- TAMBAHKAN METHOD DI BAWAH INI ---

    /**
     * Menampilkan form untuk mengedit quiz.
     */
    public function edit(Quiz $quiz)
    {
        if ($quiz->guru_id !== Auth::id()) abort(403);

        $kelas = Kelas::with('jurusan')->get();
        return view('guru.quiz.edit', compact('quiz', 'kelas'));
    }

    /**
     * Memperbarui data quiz di database.
     */
    public function update(Request $request, Quiz $quiz)
    {
        if ($quiz->guru_id !== Auth::id()) abort(403);

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $quiz->update($request->all());

        return redirect()->route('guru.quiz.index')->with('success', 'Quiz berhasil diperbarui.');
    }

    /**
     * Menghapus quiz dari database.
     */
    public function destroy(Quiz $quiz)
    {
        if ($quiz->guru_id !== Auth::id()) abort(403);

        $quiz->delete();

        return redirect()->route('guru.quiz.index')->with('success', 'Quiz berhasil dihapus.');
    }
}
