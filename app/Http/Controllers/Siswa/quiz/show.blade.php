<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mengerjakan: {{ $quiz->judul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('siswa.quiz.store', $quiz) }}" method="POST">
                @csrf
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-8">
                    @if($quiz->questions->isEmpty())
                        <p class="text-center text-gray-500">Quiz ini belum memiliki pertanyaan.</p>
                    @else
                        @foreach ($quiz->questions as $question)
                            <div class="border-b pb-6">
                                <p class="font-semibold text-lg">{{ $loop->iteration }}. {{ $question->pertanyaan }}</p>
                                <div class="mt-4 space-y-2">
                                    @foreach ($question->answers as $answer)
                                        <label class="flex items-center p-2 rounded-md hover:bg-gray-100 cursor-pointer">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $answer->id }}" class="mr-3 h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" required>
                                            <span>{{ $answer->jawaban }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="flex justify-end">
                            <x-primary-button onclick="return confirm('Apakah Anda yakin ingin menyelesaikan dan mengirim jawaban quiz ini?')">
                                Selesaikan Quiz
                            </x-primary-button>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
