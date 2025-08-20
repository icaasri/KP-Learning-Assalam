<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Pertanyaan untuk Quiz: {{ $quiz->judul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                        </div>
                    @endif
                    <form action="{{ route('guru.quiz.questions.update', [$quiz, $question]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <x-input-label for="pertanyaan" value="Teks Pertanyaan" />
                            <textarea name="pertanyaan" id="pertanyaan" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('pertanyaan', $question->pertanyaan) }}</textarea>
                        </div>

                        <div class="mt-4">
                            <x-input-label value="Pilihan Jawaban (Tandai jawaban yang benar)" />
                            @foreach ($question->answers as $key => $answer)
                            <div class="flex items-center mt-2">
                                <input type="radio" name="jawaban_benar" value="{{ $key }}" class="mr-2" required @checked($answer->is_correct)>
                                <x-text-input type="text" name="jawaban[]" class="w-full" value="{{ old('jawaban.' . $key, $answer->jawaban) }}" required />
                            </div>
                            @endforeach
                        </div>

                        <div class="flex items-center justify-end mt-6">
                             <a href="{{ route('guru.quiz.show', $quiz) }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>Simpan Perubahan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>