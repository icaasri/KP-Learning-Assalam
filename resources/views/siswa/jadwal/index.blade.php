<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Pelajaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Jadwal Kelas: {{ Auth::user()->kelas->tingkat ?? '' }} {{ Auth::user()->kelas->jurusan->singkatan ?? '' }} {{ Auth::user()->kelas->nama_kelas ?? 'Belum terdaftar' }}
                    </h3>

                    @if(Auth::user()->kelas_id && $jadwals->count() > 0)
                        <div class="space-y-6">
                            @foreach ($jadwals as $hari => $jadwalHarian)
                                <div>
                                    <h4 class="font-bold text-lg mb-2 border-b pb-1">{{ $hari }}</h4>
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full">
                                            <tbody>
                                                @foreach ($jadwalHarian as $jadwal)
                                                    <tr class="border-b last:border-b-0">
                                                        <td class="py-3 px-2 w-1/4 text-sm text-gray-500">{{ date('H:i', strtotime($jadwal->waktu_mulai)) }} - {{ date('H:i', strtotime($jadwal->waktu_selesai)) }}</td>
                                                        <td class="py-3 px-2 font-semibold">{{ $jadwal->mata_pelajaran }}</td>
                                                        <td class="py-3 px-2 text-sm text-gray-600">{{ $jadwal->guru->name }}</td>
                                                        <td class="py-3 px-2 text-sm text-gray-500 text-right">{{ $jadwal->ruangan }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-10">Jadwal pelajaran belum tersedia untuk kelas Anda.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>