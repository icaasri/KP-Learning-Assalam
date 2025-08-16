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
}
