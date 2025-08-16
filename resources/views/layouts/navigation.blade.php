<!-- Sidebar -->
<div class="w-64 bg-assalam-dark-blue text-white flex flex-col">
    <!-- Logo -->
    <div class="h-16 flex items-center justify-center border-b border-gray-700">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <img src="{{ asset('images/smk.png') }}" alt="Logo SMK As Salam" class="h-10 w-10">
            <span class="font-bold text-lg">E-Learning Assalaam</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-4 py-6 space-y-2">
        <h3 class="px-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">Menu Utama</h3>
        
        <x-side-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard') || request()->routeIs('admin.dashboard')">
            <i class="fas fa-tachometer-alt w-6"></i>
            <span>Dashboard</span>
        </x-side-nav-link>

        {{-- ================= MENU ADMIN ================= --}}
        @if(Auth::user()->role == 'admin')
            <h3 class="px-2 pt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Admin</h3>
            <x-side-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                <i class="fas fa-users-cog w-6"></i>
                <span>Manajemen User</span>
            </x-side-nav-link>
            <x-side-nav-link :href="route('admin.jadwal.index')" :active="request()->routeIs('admin.jadwal.*')">
                <i class="fas fa-calendar-alt w-6"></i>
                <span>Manajemen Jadwal</span>
            </x-side-nav-link>
        @endif

        {{-- ================= MENU GURU ================= --}}
        @if(Auth::user()->role == 'guru')
            <h3 class="px-2 pt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Guru</h3>
            <x-side-nav-link :href="route('guru.materi.index')" :active="request()->routeIs('guru.materi.*')">
                <i class="fas fa-book-open w-6"></i>
                <span>Manajemen Materi</span>
            </x-side-nav-link>
            <x-side-nav-link :href="route('guru.quiz.index')" :active="request()->routeIs('guru.quiz.*')">
                <i class="fas fa-puzzle-piece w-6"></i>
                <span>Manajemen Quiz</span>
            </x-side-nav-link>
        @endif

        {{-- ================= MENU SISWA ================= --}}
        @if(Auth::user()->role == 'siswa')
            <h3 class="px-2 pt-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Siswa</h3>
            <x-side-nav-link :href="route('siswa.materi.index')" :active="request()->routeIs('siswa.materi.*')">
                <i class="fas fa-book w-6"></i>
                <span>Materi</span>
            </x-side-nav-link>
            <x-side-nav-link :href="route('siswa.quiz.index')" :active="request()->routeIs('siswa.quiz.*')">
                <i class="fas fa-pen-alt w-6"></i>
                <span>Quiz</span>
            </x-side-nav-link>
            <x-side-nav-link :href="route('siswa.jadwal.index')" :active="request()->routeIs('siswa.jadwal.*')">
                <i class="fas fa-calendar-day w-6"></i>
                <span>Jadwal Belajar</span>
            </x-side-nav-link>
        @endif

    </nav>

    <!-- User Profile & Logout -->
    <div class="border-t border-gray-700 p-4">
        <x-side-nav-link :href="route('profile.edit')">
            <i class="fas fa-user-circle w-6"></i>
            <span>Profil Saya</span>
        </x-side-nav-link>
        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-side-nav-link :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                <i class="fas fa-sign-out-alt w-6"></i>
                <span>Log Out</span>
            </x-side-nav-link>
        </form>
    </div>
</div>
