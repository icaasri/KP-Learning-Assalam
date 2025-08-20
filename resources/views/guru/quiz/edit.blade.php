<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Quiz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('guru.quiz.update', $quiz) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <x-input-label for="judul" value="Judul Quiz" />
                            <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul" :value="old('judul', $quiz->judul)" required />
                        </div>
                        <div class="mt-4">
                            <x-input-label for="deskripsi" value="Deskripsi (Opsional)" />
                            <textarea id="deskripsi" name="deskripsi" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('deskripsi', $quiz->deskripsi) }}</textarea>
                        </div>
                        <div class="mt-4">
                            <x-input-label for="kelas_id" value="Untuk Kelas" />
                            <select name="kelas_id" id="kelas_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                                <option>Pilih Kelas</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}" @selected(old('kelas_id', $quiz->kelas_id) == $k->id)>
                                        {{ $k->tingkat }} {{ $k->jurusan->singkatan }} {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex justify-end mt-4">
                            <a href="{{ route('guru.quiz.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                Simpan Perubahan
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
