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
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                        </div>
                    @endif
                    
                    {{-- PERBAIKAN ADA DI BARIS INI --}}
                    <form action="{{ route('guru.quiz.questions.store', $quiz) }}" method="POST">
                        @csrf
                        <div>
                            <x-input-label for="pertanyaan" value="Teks Pertanyaan" />
                            <textarea name="pertanyaan" id="pertanyaan" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('pertanyaan') }}</textarea>
                        </div>
                        <div class="mt-4">
                            <x-input-label value="Pilihan Jawaban (Tandai jawaban yang benar)" />
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
                                <div class="flex justify-between items-start">
                                    <div>
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
                                    <div class="flex-shrink-0 ml-4">
                                        {{-- PERBAIKAN JUGA ADA DI BARIS INI --}}
                                        <a href="{{ route('guru.quiz.questions.edit', [$quiz, $question]) }}" class="text-sm text-indigo-600 hover:text-indigo-900">Edit</a>
                                        <form action="{{ route('guru.quiz.questions.destroy', [$quiz, $question]) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Yakin ingin menghapus pertanyaan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500">Belum ada pertanyaan di quiz ini.</p>
                        @endforelse
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <a href="{{ route('guru.quiz.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Selesai & Kembali ke Daftar Quiz
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>