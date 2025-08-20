<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function store(Request $request, Quiz $quiz)
    {
        // Otorisasi: pastikan guru adalah pemilik quiz
        if ($quiz->guru_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|array|min:2',
            'jawaban.*' => 'required|string',
            'jawaban_benar' => 'required|integer',
        ]);

        DB::transaction(function () use ($request, $quiz) {
            // 1. Simpan Pertanyaan
            $question = $quiz->questions()->create([
                'pertanyaan' => $request->pertanyaan,
            ]);

            // 2. Simpan Pilihan Jawaban
            foreach ($request->jawaban as $key => $jawabanText) {
                $isCorrect = ($key == $request->jawaban_benar);
                $question->answers()->create([
                    'jawaban' => $jawabanText,
                    'is_correct' => $isCorrect,
                ]);
            }
        });

        return back()->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function edit(Quiz $quiz, Question $question)
    {
        if ($quiz->guru_id !== Auth::id() || $question->quiz_id !== $quiz->id) {
            abort(403);
        }

        $question->load('answers');
        return view('guru.quiz.questions.edit', compact('quiz', 'question'));
    }

    /**
     * Memperbarui pertanyaan di database.
     */
    public function update(Request $request, Quiz $quiz, Question $question)
    {
        if ($quiz->guru_id !== Auth::id() || $question->quiz_id !== $quiz->id) {
            abort(403);
        }

        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|array|min:4|max:4',
            'jawaban.*' => 'required|string',
            'jawaban_benar' => 'required|string', // Kunci dari jawaban yang benar
        ]);

        DB::transaction(function () use ($request, $question) {
            // Update teks pertanyaan
            $question->update(['pertanyaan' => $request->pertanyaan]);

            // Hapus jawaban lama dan buat yang baru
            $question->answers()->delete();

            // Buat ulang pilihan jawaban
            foreach ($request->jawaban as $key => $jawabanText) {
                $isCorrect = ($key == $request->jawaban_benar);
                $question->answers()->create([
                    'jawaban' => $jawabanText,
                    'is_correct' => $isCorrect,
                ]);
            }
        });

        return redirect()->route('guru.quiz.show', $quiz)->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    /**
     * Menghapus pertanyaan dari database.
     */
    public function destroy(Quiz $quiz, Question $question)
    {
        if ($quiz->guru_id !== Auth::id() || $question->quiz_id !== $quiz->id) {
            abort(403);
        }

        $question->delete();

        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
