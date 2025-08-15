<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .login-bg {
            background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACoCAMAAABt9SM9AAAAA1BMVEX///+nxBvIAAAAR0lEQVR4nO3BAQEAAACCIP+vbkhAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAO8GxYgAAb0jQ/cAAAAASUVORK5CYII='); /* Ganti dengan pola background dari gambar jika punya */
            background-size: cover;
            background-position: center;
            opacity: 0.1;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
        }
        .auth-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .left-panel {
             /* Menggunakan warna biru gelap seperti di contoh */
            background-color: #2c3e50;
            padding: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .left-panel-image {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <div class="login-bg"></div>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="w-full sm:max-w-4xl mx-auto flex auth-card">
            <div class="hidden md:flex w-1/3 left-panel">
                <img src="https://i.ibb.co/L6FpXjC/side-image.png" alt="E-Learning Illustration" class="left-panel-image">
            </div>

            <div class="w-full md:w-2/3 px-6 py-12">
                 <div class="text-center mb-8">
                    <a href="/">
                        <img src="{{ asset('images/smk.png') }}" alt="Logo SMK As Salam" class="w-24 h-24 mx-auto mb-4">
                    </a>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-input-label for="login" value="Username atau Gmail" />
                        <x-text-input id="login" class="block mt-1 w-full" type="text" name="login" :value="old('login')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('login')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" value="Password" />
                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>