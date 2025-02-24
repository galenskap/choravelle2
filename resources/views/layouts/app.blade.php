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
        @stack('scripts')
    </head>
    <body class="font-sans antialiased app-layout">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            @hasSection('content')
                <main class="main-container">@yield('content')</main>            
            @else
                <main class="main-container">{{ $slot }}</main>
            @endif

            <footer class="w-full py-4 mt-auto bg-white border-t">
                <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-600">
                        <div class="mb-4 md:mb-0">
                            <a href="{{ route('page.show', ['slug' => 'mentions-legales']) }}" class="hover:text-gray-900 mr-4">Mentions légales</a>
                            <a href="/administration" class="hover:text-gray-900" rel="nofollow">Administration</a>
                        </div>
                        <div class="flex items-center text-right">
                            <span>Un site <a href="https://lude-web.studio" class="hover:text-gray-900" target="_blank"><strong>Lude Web Studio</strong></a><br>
                             propulsé par <a href="https://github.com/galenskap/choravelle2" class="hover:text-gray-900" target="_blank" rel="noopener">Choravelle</a></span>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
