<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $materi->judul }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('siswa.materi.index') }}" class="text-blue-500 hover:underline mb-6 inline-block">&larr; Kembali ke Daftar Materi</a>
                    
                    <h3 class="text-2xl font-bold">{{ $materi->judul }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Oleh: {{ $materi->guru->name }}</p>
                    <p class="mt-4 text-gray-700">{{ $materi->deskripsi }}</p>
                    
                    <hr class="my-6">

                    {{-- Tampilkan konten berdasarkan tipe materi --}}
                    @if ($materi->tipe == 'pdf' && $materi->file_path)
                        <div>
                            <h4 class="font-bold mb-2">Materi PDF:</h4>
                            <iframe src="{{ Storage::url($materi->file_path) }}" width="100%" height="600px"></iframe>
                            <a href="{{ Storage::url($materi->file_path) }}" target="_blank" class="mt-4 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700">
                                Download PDF
                            </a>
                        </div>
                    @elseif ($materi->tipe == 'video' && $materi->youtube_url)
                        <div>
                            <h4 class="font-bold mb-2">Video Pembelajaran:</h4>
                            <div class="aspect-w-16 aspect-h-9">
                                <iframe src="{{ $materi->youtube_url }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                    @else
                        <p class="text-red-500">Konten materi tidak dapat ditampilkan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
