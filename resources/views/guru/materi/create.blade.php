<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Materi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if ($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('guru.materi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div>
                            <x-input-label for="judul" :value="__('Judul Materi')" />
                            <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul" :value="old('judul')" required autofocus />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="deskripsi" :value="__('Deskripsi (Opsional)')" />
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <x-input-label for="kelas_id" :value="__('Untuk Kelas')" />
                            <select name="kelas_id" id="kelas_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $k)
                                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->tingkat }} {{ $k->jurusan->singkatan }} {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mt-4">
                            <x-input-label for="tipe" :value="__('Tipe Materi')" />
                            <select name="tipe" id="tipe" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="pdf" {{ old('tipe') == 'pdf' ? 'selected' : '' }}>PDF</option>
                                <option value="video" {{ old('tipe') == 'video' ? 'selected' : '' }}>Video YouTube</option>
                            </select>
                        </div>

                        <div class="mt-4" id="file-pdf-container">
                            <x-input-label for="file_pdf" :value="__('Upload File PDF')" />
                            <input type="file" name="file_pdf" id="file_pdf" class="block mt-1 w-full">
                        </div>

                        <div class="mt-4 hidden" id="youtube-url-container">
                            <x-input-label for="youtube_url" :value="__('Link Video YouTube')" />
                            <x-text-input id="youtube_url" class="block mt-1 w-full" type="url" name="youtube_url" :value="old('youtube_url')" placeholder="Contoh: https://www.youtube.com/watch?v=xxxx" />
                        </div>
                        
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('guru.materi.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Materi') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('tipe').addEventListener('change', function() {
            let pdfContainer = document.getElementById('file-pdf-container');
            let youtubeContainer = document.getElementById('youtube-url-container');
            if (this.value === 'pdf') {
                pdfContainer.classList.remove('hidden');
                youtubeContainer.classList.add('hidden');
            } else {
                pdfContainer.classList.add('hidden');
                youtubeContainer.classList.remove('hidden');
            }
        });
        // Trigger change event on page load to set initial state
        document.getElementById('tipe').dispatchEvent(new Event('change'));
    </script>
</x-app-layout>
