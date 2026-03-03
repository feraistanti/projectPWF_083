<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel - Fera Istanti</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-900 text-white">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen selection:bg-indigo-500 selection:text-white">
        
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-400 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-gray-400 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-400 hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-indigo-500">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-4xl mx-auto p-6 lg:p-8">
            <div class="bg-gray-800 border border-gray-700 rounded-3xl p-10 shadow-2xl relative overflow-hidden">
                <div class="absolute -top-24 -left-24 w-48 h-48 bg-indigo-600 rounded-full blur-[100px] opacity-20"></div>
                
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <h1 class="text-5xl font-extrabold tracking-tight">
                            Fera Istanti
                        </h1>
                        <p class="mt-2 text-xl text-gray-400 font-mono">
                            NIM: <span class="text-indigo-400">20230140083</span>
                        </p>
                    </div>

                    <div class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full text-sm font-bold shadow-lg">
                        Mahasiswa Informatika
                    </div>
                </div>

                <div class="mt-12 h-[1px] bg-gray-700"></div>

                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="#" class="flex items-center gap-3 bg-white text-gray-900 px-6 py-3 rounded-xl font-bold hover:bg-gray-200 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path></svg>
                        Modul Pertemuan 1
                    </a>
                    
                    <a href="#" class="flex items-center gap-3 bg-gray-700 text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                        Lihat Project
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>