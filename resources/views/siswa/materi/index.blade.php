<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900">Daftar Materi Pelajaran</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Berikut adalah daftar materi yang tersedia untuk kelas Anda.
                    </p>
                </div>
            </div>

            <div class="mt-6 space-y-6">
                @forelse ($materis as $materi)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-xl font-bold">{{ $materi->judul }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Oleh: {{ $materi->guru->name }} | Diunggah: {{ $materi->created_at->format('d M Y') }}
                                    </p>
                                    <p class="mt-3 text-gray-700">{{ $materi->deskripsi }}</p>
                                </div>
                                <span class="px-3 py-1 text-xs leading-5 font-semibold rounded-full {{ $materi->tipe == 'pdf' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ strtoupper($materi->tipe) }}
                                </span>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('siswa.materi.show', $materi) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                    Lihat Materi &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center text-gray-500">
                            Belum ada materi yang tersedia untuk kelas Anda.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $materis->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
