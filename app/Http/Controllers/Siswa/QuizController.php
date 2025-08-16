<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * Menampilkan daftar quiz yang tersedia untuk kelas siswa.
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user->kelas_id) {
            return view('siswa.quiz.index')->with('quizzes', collect());
        }

        $quizzes = Quiz::where('kelas_id', $user->kelas_id)
                       ->with('guru')
                       ->withCount('questions')
                       ->latest()
                       ->paginate(10);

        return view('siswa.quiz.index', compact('quizzes'));
    }

    /**
     * Menampilkan halaman untuk mengerjakan quiz.
     */
    public function show(Quiz $quiz)
    {
        // Keamanan: Pastikan siswa hanya bisa mengakses quiz untuk kelasnya.
        if (Auth::user()->kelas_id !== $quiz->kelas_id) {
            abort(403);
        }

        // Ambil pertanyaan dan acak urutannya, beserta jawaban yang juga diacak.
        $quiz->load(['questions' => function ($query) {
            $query->inRandomOrder()->with(['answers' => function ($query) {
                $query->inRandomOrder();
            }]);
        }]);

        return view('siswa.quiz.show', compact('quiz'));
    }

    /**
     * Menyimpan jawaban siswa dan menghitung skor.
     */
    public function store(Request $request, Quiz $quiz)
    {
        if (Auth::user()->kelas_id !== $quiz->kelas_id) {
            abort(403);
        }

        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|integer|exists:answers,id',
        ]);

        $attempt = DB::transaction(function () use ($request, $quiz) {
            // 1. Buat catatan pengerjaan (attempt)
            $attempt = QuizAttempt::create([
                'user_id' => Auth::id(),
                'quiz_id' => $quiz->id,
            ]);

            $totalCorrect = 0;

            // 2. Simpan setiap jawaban siswa dan periksa kebenarannya
            foreach ($request->answers as $questionId => $answerId) {
                $answer = Answer::find($answerId);
                $isCorrect = $answer ? $answer->is_correct : false;
                
                if ($isCorrect) {
                    $totalCorrect++;
                }

                $attempt->siswaAnswers()->create([
                    'question_id' => $questionId,
                    'answer_id' => $answerId,
                    'is_correct' => $isCorrect,
                ]);
            }

            // 3. Hitung dan simpan skor akhir
            $totalQuestions = $quiz->questions()->count();
            $score = ($totalQuestions > 0) ? ($totalCorrect / $totalQuestions) * 100 : 0;
            $attempt->update(['skor' => $score]);
            
            return $attempt;
        });

        // Arahkan ke halaman hasil setelah selesai
        return redirect()->route('siswa.quiz.result', $attempt)->with('success', 'Quiz berhasil diselesaikan!');
    }

    /**
     * Menampilkan halaman hasil quiz.
     */
    public function result(QuizAttempt $attempt)
    {
        // Keamanan: Pastikan siswa hanya bisa melihat hasilnya sendiri.
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        $attempt->load('quiz');

        return view('siswa.quiz.result', compact('attempt'));
    }
}
