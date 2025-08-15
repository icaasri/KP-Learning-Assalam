<x-app-layout>
    {{-- Slot untuk Header Halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    {{-- Menambahkan Font Awesome untuk Ikon --}}
    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Kartu Sambutan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Anda login sebagai **Admin**. Di sini Anda dapat mengelola seluruh sistem e-learning.
                    </p>
                </div>
            </div>

            {{-- Kartu Statistik --}}
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Card 1: Jumlah Siswa -->
                <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg flex flex-col justify-between">
                    <div class="flex items-center">
                        <div class="text-3xl opacity-75">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="ml-4">
                            {{-- Menggunakan variabel dinamis dari controller --}}
                            <p class="font-bold text-4xl">{{ $jumlahSiswa }}</p>
                            <p>Total Siswa</p>
                        </div>
                    </div>
                    <a href="#" class="mt-4 inline-block text-sm self-start hover:underline">Lihat Detail &rarr;</a>
                </div>

                <!-- Card 2: Jumlah Guru -->
                <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg flex flex-col justify-between">
                    <div class="flex items-center">
                        <div class="text-3xl opacity-75">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <div class="ml-4">
                            {{-- Menggunakan variabel dinamis dari controller --}}
                            <p class="font-bold text-4xl">{{ $jumlahGuru }}</p>
                            <p>Total Guru</p>
                        </div>
                    </div>
                    <a href="#" class="mt-4 inline-block text-sm self-start hover:underline">Lihat Detail &rarr;</a>
                </div>

                <!-- Card 3: Jumlah Materi -->
                <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-lg flex flex-col justify-between">
                     <div class="flex items-center">
                        <div class="text-3xl opacity-75">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="ml-4">
                            {{-- Masih menggunakan data dummy, akan diupdate nanti --}}
                            <p class="font-bold text-4xl">0</p>
                            <p>Total Materi</p>
                        </div>
                    </div>
                    <a href="#" class="mt-4 inline-block text-sm self-start hover:underline">Lihat Detail &rarr;</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>