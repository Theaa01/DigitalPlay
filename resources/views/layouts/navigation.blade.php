{{-- <!-- resources/views/layouts/navigation.blade.php -->
<nav class="bg-gray-800 text-white">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="text-2xl font-bold">DigitalPlay</a>

            <!-- Links de Navegación -->
            <div class="flex space-x-4">
                <a href="{{ route('home') }}" class="hover:text-orange-500">Inicio</a>
                <a href="{{ route('productos') }}" class="hover:text-orange-500">Productos</a>
                <a href="{{ route('contacto') }}" class="hover:text-orange-500">Contacto</a>
                <a href="{{ route('ubicacion') }}" class="hover:text-orange-500">Ubícanos</a>
            </div>

            <!-- Botones de Login y Registro -->
            <div class="flex space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-orange-500">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="hover:text-orange-500">Cerrar Sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-orange-500">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="hover:text-orange-500">Registrarse</a>
                @endauth
            </div>
        </div>
    </div>
</nav> --}}
