<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        
        <div class="w-full sm:max-w-4xl mx-auto flex bg-white shadow-lg rounded-lg overflow-hidden">
            
            <!-- Panel Kiri dengan Gambar -->
            <div class="hidden md:flex w-1/3 bg-gray-800 p-8 items-center justify-center">
                <div class="text-white text-center">
                    <h2 class="text-3xl font-bold">E-Learning</h2>
                    <p class="mt-2">SMK As Salam</p>
                </div>
            </div>

            <!-- Panel Kanan dengan Form -->
            <div class="w-full md:w-2/3 px-6 py-12">
                <div class="text-center mb-8">
                    <a href="/">
                        <img src="{{ asset('images/smk.png') }}" alt="Logo SMK As Salam" class="w-24 h-24 mx-auto">
                    </a>
                </div>
                
                <!-- Menampilkan Error Login -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <span class="block sm:inline">{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Username atau Gmail -->
                    <div>
                        <label for="login" class="block font-medium text-sm text-gray-700">Username atau Gmail</label>
                        <input id="login" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                               type="text" name="login" value="{{ old('login') }}" required autofocus />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password" class="block font-medium text-sm text-gray-700">Password</label>
                        <input id="password" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                               type="password" name="password" required autocomplete="current-password" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
