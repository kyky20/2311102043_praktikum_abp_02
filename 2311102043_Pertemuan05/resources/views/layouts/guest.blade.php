<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-stone-900 antialiased bg-stone-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-stone-100 to-stone-200">
            <div>
                <a href="/">
                    <!-- Elegant Custom Icon -->
                    <svg class="w-16 h-16 text-amber-600 drop-shadow-sm transition-transform hover:scale-105" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.636l-.183-2.923C20.67 6.402 16.815 3 12 3s-8.67 3.402-8.91 7.64l-.183 2.923c-.01.58.23 1.137.669 1.517m17.164 0a3.024 3.024 0 01-3.693 3.6932a3.024 3.024 0 01-3.693 3.693m7.386-7.386a3.024 3.024 0 00-3.693 3.693m-3.693 3.693a3.024 3.024 0 00-3.693-3.693m0 0a3.024 3.024 0 01-3.693-3.693m3.693 3.693A3.024 3.024 0 0012 18z" /></svg>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-10 py-10 bg-white shadow-2xl border border-stone-200/60 overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
