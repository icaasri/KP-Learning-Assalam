<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hasil Quiz: {{ $attempt->quiz->judul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <h3 class="text-2xl font-bold">Quiz Selesai!</h3>
                    <p class="mt-2 text-gray-600">Berikut adalah hasil pengerjaan Anda.</p>
                    <div class="my-8">
                        <p class="text-lg">Skor Anda:</p>
                        <p class="text-6xl font-bold text-green-600">{{ round($attempt->skor) }}</p>
                    </div>
                    <a href="{{ route('siswa.quiz.index') }}" class="text-blue-500 hover:underline">
                        &larr; Kembali ke Daftar Quiz
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
