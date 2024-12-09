<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

        <!-- Font Awesome -->
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
            integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @stack('styles') <!-- Para estilos adicionales si es necesario -->
    </head>
    <body class="font-sans antialiased @yield('body-class') ">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Navbar -->
        @php
            // Determina si el navbar debe estar siempre con fondo oscuro
            $navbarAlwaysScrolled = isset($navbarAlwaysScrolled) ? $navbarAlwaysScrolled : false;
            // Define las clases de fondo al hacer scroll
            $navbarScrolledBackground = isset($navbarScrolledBackground) ? $navbarScrolledBackground : 'bg-black/60 backdrop-blur-md';
        @endphp

        @include('components.navbar', [
            'alwaysScrolled' => $navbarAlwaysScrolled,
            'scrolledBackground' => $navbarScrolledBackground
        ])
            <!-- Mobile Menu -->
            @include('components.mobile-menu')

            <!-- Modal del Carrito -->
            @include('components.cart-modal')

            <!-- Header Banner (Opcional) -->
            @hasSection('header-banner')
                @yield('header-banner')
            @endif

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="min-h-screen">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('components.footer')
        </div>

        <!-- Scripts -->
        @stack('scripts')
    </body>
</html>