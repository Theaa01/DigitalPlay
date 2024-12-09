<!-- resources/views/components/footer.blade.php -->
<footer id="footer-container" class="bg-gray-800 text-white py-12 ">
    <div class="container mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            
            <!-- Información de la Empresa -->
            <div class="mb-8 md:mb-0">
                <a href="{{ route('inicio') }}" class="text-orange-500 text-2xl font-extrabold uppercase mb-4 inline-block">DigitalPlay</a>
                <p class="text-gray-400 max-w-sm">
                    DigitalPlay es tu tienda online de confianza para encontrar los mejores juegos y accesorios. ¡Descubre tu próximo juego favorito hoy mismo!
                </p>
            </div>
            
            <!-- Enlaces de Navegación -->
            <div class="mb-8 md:mb-0">
                <h3 class="text-xl font-semibold mb-4">Enlaces Rápidos</h3>
                <ul>
                    <li class="mb-2">
                        <a href="{{ route('inicio') }}" class="text-gray-400 hover:text-orange-500 transition">Inicio</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('games') }}" class="text-gray-400 hover:text-orange-500 transition">Productos</a>
                    </li>
                    <li class="mb-2">
                        <a href="#contact" class="text-gray-400 hover:text-orange-500 transition">Contacto</a>
                    </li>
                    <li class="mb-2">
                        <a href="#mapa" class="text-gray-400 hover:text-orange-500 transition">Ubícanos</a>
                    </li>
                </ul>
            </div>
            
            <!-- Enlaces de Ayuda -->
            <div class="mb-8 md:mb-0">
                <h3 class="text-xl font-semibold mb-4">Recursos</h3>
                <ul>
                    <li class="mb-2">
                        <a href="{{{ route('terminos') }}}" class="text-gray-400 hover:text-orange-500 transition">Términos y Condiciones</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('politicas') }}" class="text-gray-400 hover:text-orange-500 transition">Política de Privacidad</a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-gray-400 hover:text-orange-500 transition">Soporte</a>
                    </li>
                </ul>
            </div>
            
            <!-- Redes Sociales -->
            <div>
                <h3 class="text-xl font-semibold mb-4">Síguenos</h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-orange-500 transition" aria-label="Facebook">
                        <!-- SVG de Facebook -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.675 0h-21.35C.595 0 0 .593 0 1.326v21.348C0 23.406.595 24 1.325 24h11.495v-9.294H9.691v-3.622h3.129V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.796.715-1.796 1.763v2.312h3.587l-.467 3.622h-3.12V24h6.116C23.406 24 24 23.406 24 22.674V1.326C24 .593 23.406 0 22.675 0z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-orange-500 transition" aria-label="Twitter">
                        <!-- SVG de Twitter -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557a9.93 9.93 0 01-2.828.775A4.932 4.932 0 0023.337 3.1a9.864 9.864 0 01-3.127 1.195A4.916 4.916 0 0016.616 3c-2.717 0-4.92 2.203-4.92 4.917 0 .385.043.76.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161a4.822 4.822 0 00-.666 2.475c0 1.708.87 3.213 2.188 4.096a4.904 4.904 0 01-2.224-.616v.062c0 2.385 1.693 4.374 3.946 4.827a4.902 4.902 0 01-2.224.084c.63 1.953 2.445 3.377 4.6 3.417A9.868 9.868 0 010 19.54a13.94 13.94 0 007.548 2.212c9.058 0 14.01-7.496 14.01-13.986 0-.213-.005-.425-.014-.636A10.025 10.025 0 0024 4.557z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-orange-500 transition" aria-label="Instagram">
                        <!-- SVG de Instagram -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.31.975.976 1.248 2.243 1.31 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.31 3.608-.976.975-2.243 1.248-3.608 1.31-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.31-.975-.976-1.248-2.243-1.31-3.608C2.175 15.747 2.163 15.367 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.31-3.608.976-.975 2.243-1.248 3.608-1.31C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.013 7.052.072 5.773.13 4.723.45 3.9 1.273 3.077 2.096 2.757 3.146 2.7 4.425 2.641 5.705 2.628 6.114 2.628 12s.013 6.295.072 7.575c.058 1.279.378 2.329 1.201 3.152.823.823 1.873 1.143 3.152 1.201 1.28.059 1.689.072 7.575.072s6.295-.013 7.575-.072c1.279-.058 2.329-.378 3.152-1.201.823-.823 1.143-1.873 1.201-3.152.059-1.28.072-1.689.072-7.575s-.013-6.295-.072-7.575c-.058-1.279-.378-2.329-1.201-3.152-.823-.823-1.873-1.143-3.152-1.201C15.311.013 14.902 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zm0 10.162a3.999 3.999 0 110-7.998 3.999 3.999 0 010 7.998zm6.406-11.845a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Línea Divisoria -->
        <hr class="my-8 border-gray-700">
        
        <!-- Derechos de Autor -->
        <div class="text-center text-gray-500">
            &copy; {{ date('Y') }} DigitalPlay. Todos los derechos reservados.
        </div>
    </div>
</footer>
