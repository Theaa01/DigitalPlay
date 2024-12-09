<!-- resources/views/components/mobile-menu.blade.php -->
<div id="mobile-menu" class="fixed inset-0 bg-gray-800 bg-opacity-95 transform translate-x-full transition-transform duration-300 ease-in-out z-50">
    <div class="container mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8 flex flex-col items-center justify-center h-full space-y-8 relative">
        <!-- Botón de Cierre -->
        <button id="close-btn" class="absolute top-6 right-6 text-white hover:text-orange-500 focus:outline-none">
            <!-- SVG de Cierre (X) -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Enlaces de Navegación -->
        <a href="{{ route('inicio') }}" class="text-white text-2xl hover:text-orange-500 font-semibold">Inicio</a>
        <a href="{{ route('games') }}" class="text-white text-2xl hover:text-orange-500 font-semibold">Productos</a>
        <a href="#contact" class="text-white text-2xl hover:text-orange-500 font-semibold">Contacto</a>
        <a href="#mapa" class="text-white text-2xl hover:text-orange-500 font-semibold">Ubícanos</a>
        @if (Route::has('login'))
            @auth
                <a href="{{ route('inicio') }}" class="text-white text-2xl hover:text-orange-500 font-semibold">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-white text-2xl hover:text-orange-500 font-semibold">Iniciar Sesión</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-white text-2xl hover:text-orange-500 font-semibold">Registrarse</a>
                @endif
            @endauth
        @endif
    </div>
</div>
