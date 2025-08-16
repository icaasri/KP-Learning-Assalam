<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Quiz: {{ $quiz->judul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Form Tambah Pertanyaan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Pertanyaan Baru</h3>
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                        </div>
                    @endif
                    <form action="{{ route('guru.quiz.questions.store', $quiz) }}" method="POST">
                        @csrf
                        <div>
                            <x-input-label for="pertanyaan" value="Teks Pertanyaan" />
                            <textarea name="pertanyaan" id="pertanyaan" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('pertanyaan') }}</textarea>
                        </div>
                        <div class="mt-4">
                            <x-input-label value="Pilihan Jawaban" />
                            @for ($i = 0; $i < 4; $i++)
                            <div class="flex items-center mt-2">
                                <input type="radio" name="jawaban_benar" value="{{ $i }}" class="mr-2" required>
                                <x-text-input type="text" name="jawaban[]" class="w-full" placeholder="Pilihan Jawaban {{ $i + 1 }}" required />
                            </div>
                            @endfor
                        </div>
                        <div class="flex justify-end mt-4">
                            <x-primary-button>Tambah Pertanyaan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Daftar Pertanyaan yang Sudah Ada -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Daftar Pertanyaan ({{ $quiz->questions->count() }})</h3>
                    <div class="space-y-4">
                        @forelse ($quiz->questions as $question)
                            <div class="border p-4 rounded-md">
                                <p class="font-semibold">{{ $loop->iteration }}. {{ $question->pertanyaan }}</p>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach ($question->answers as $answer)
                                        <li class="{{ $answer->is_correct ? 'text-green-600 font-bold' : '' }}">
                                            {{ $answer->jawaban }}
                                            @if ($answer->is_correct) (Jawaban Benar) @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada pertanyaan di quiz ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
