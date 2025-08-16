<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Banner -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="mt-2 text-gray-600">
                        Anda login sebagai **Admin**. Dari sini Anda dapat mengelola seluruh data sistem e-learning SMK As Salam.
                    </p>
                </div>
            </div>

            <!-- Kartu Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Card 1: Jumlah Siswa -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-user-graduate text-2xl text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Siswa</p>
                        <p class="font-bold text-3xl">{{ $jumlahSiswa }}</p>
                    </div>
                </div>

                <!-- Card 2: Jumlah Guru -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-chalkboard-teacher text-2xl text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Guru</p>
                        <p class="font-bold text-3xl">{{ $jumlahGuru }}</p>
                    </div>
                </div>

                <!-- Card 3: Jumlah Materi (Contoh) -->
                <div class="bg-white p-6 rounded-lg shadow-lg flex items-center space-x-4">
                     <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-book text-2xl text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Materi</p>
                        <p class="font-bold text-3xl">0</p>
                    </div>
                </div>
            </div>

            <!-- Pintasan Cepat -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pintasan Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.users.create') }}" class="bg-gray-50 hover:bg-gray-100 p-4 rounded-lg text-center transition">
                            <i class="fas fa-user-plus text-3xl text-gray-500 mb-2"></i>
                            <p class="font-semibold">Tambah User Baru</p>
                        </a>
                        <a href="{{ route('admin.jadwal.create') }}" class="bg-gray-50 hover:bg-gray-100 p-4 rounded-lg text-center transition">
                            <i class="fas fa-calendar-plus text-3xl text-gray-500 mb-2"></i>
                            <p class="font-semibold">Tambah Jadwal Baru</p>
                        </a>
                         <a href="{{ route('admin.users.index') }}" class="bg-gray-50 hover:bg-gray-100 p-4 rounded-lg text-center transition">
                            <i class="fas fa-list-ul text-3xl text-gray-500 mb-2"></i>
                            <p class="font-semibold">Lihat Semua User</p>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
