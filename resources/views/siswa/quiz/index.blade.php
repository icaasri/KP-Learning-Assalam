<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Quiz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @forelse ($quizzes as $quiz)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6">
                        <h4 class="text-xl font-bold">{{ $quiz->judul }}</h4>
                        <p class="text-sm text-gray-500 mt-1">
                            Oleh: {{ $quiz->guru->name }} | Jumlah Soal: {{ $quiz->questions_count }}
                        </p>
                        <p class="mt-3 text-gray-700">{{ $quiz->deskripsi }}</p>
                        <div class="mt-4">
                            <a href="{{ route('siswa.quiz.show', $quiz) }}" class="bg-green-500 text-white font-bold py-2 px-4 rounded hover:bg-green-700">
                                Kerjakan Quiz
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center text-gray-500">
                        Belum ada quiz yang tersedia untuk kelas Anda.
                    </div>
                </div>
            @endforelse
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $quizzes->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
