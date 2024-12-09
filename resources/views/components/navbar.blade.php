@props([
    'alwaysScrolled' => false,
    'scrolledBackground' => 'bg-black/60 backdrop-blur-md',
    'cartCount' => 0
])

<style>
    .glass-dropdown {
        background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0.1));
        backdrop-filter: blur(20px) saturate(150%) contrast(1.2) brightness(1.1);
        -webkit-backdrop-filter: blur(30px) saturate(150%) contrast(1.3) brightness(1.2);
        border: 1px solid rgba(255,255,255,0.2);
        box-shadow: 0 4px 14px rgba(0,0,0,0.3);
        border-radius: 0.5rem;
        width: 14rem;
        /* Removemos display:none aquí, controlaremos con la clase hidden */
        position: fixed;
    }

    .glass-dropdown:hover {
        background: linear-gradient(135deg, rgba(255,255,255,0.25), rgba(255,255,255,0.15));
    }
</style>

<div id="navbar-container"
    class="fixed top-0 left-0 right-0 w-full z-20 transition-colors duration-300 {{ $alwaysScrolled ? $scrolledBackground : 'bg-black/60' }}"
    data-always-scrolled="{{ $alwaysScrolled ? 'true' : 'false' }}" data-scrolled-background="{{ $scrolledBackground }}">

    <div id="navbar" class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8 flex justify-between items-center py-4">
        <!-- Logo -->
        <a href="{{ route('inicio') }}" class="text-orange-500 text-2xl font-extrabold uppercase font-sans">DigitalPlay</a>

        <!-- Navegación Principal (Escritorio) -->
        <div class="hidden md:flex items-center space-x-6">
            <nav class="flex space-x-8">
                <a href="{{ route('inicio') }}" class="text-white hover:text-orange-500 font-semibold">Inicio</a>
                <a href="{{ route('games') }}" class="text-white hover:text-orange-500 font-semibold">Productos</a>
                <a href="#contact" class="text-white hover:text-orange-500 font-semibold">Contacto</a>
                <a href="#mapa" class="text-white hover:text-orange-500 font-semibold">Ubícanos</a>
            </nav>

            <!-- Iconos -->
            <div class="flex items-center space-x-4">
                <!-- Barra de Búsqueda -->
                <div class="relative">
                    <div
                        class="flex items-center bg-orange-500 rounded-full shadow-lg p-2 w-12 h-12 transition-all duration-500 text-white search-container">
                        <form class="flex-grow">
                            <input id="search" name="search" type="text" placeholder="Buscar juegos..."
                                class="bg-orange-500 border-none flex-grow outline-none px-4 py-0 transition-all duration-500 w-0 placeholder:text-white text-white">
                            <span id="sbtn" class="text-white pr-2 transition-all duration-500 absolute right-2 top-3 hover:scale-110">
                                <i class="fas fa-search"></i>
                            </span>
                        </form>
                        <style>
                            .search-container.expanded,
                            .search-container:focus-within {
                                width: 24rem;
                                height: 3rem;
                            }

                            .search-container.expanded input,
                            .search-container:focus-within input {
                                width: 15rem;
                                padding-left: 2rem;
                                padding-right: 2.5rem;
                            }

                            input:focus {
                                box-shadow: none !important;
                                border: none !important;
                            }
                        </style>
                    </div>
                </div>

                <!-- Icono del Carrito -->
                <button id="cart-btn" class="relative text-white hover:text-orange-500 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 3h2l.4 2m.6 3h14l-1.68 7H7.88m0 0L6.2 8H20M7.88 21a2 2 0 100-4 2 2 0 000 4z"/>
                    </svg>
                    <span id="cartItemCount"
                          class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                        {{ $cartCount }}
                    </span>
                </button>

                <!-- Menú de Usuario -->
                <div class="relative">
                    @auth
                        <button id="user-menu-btn" class="flex items-center text-white hover:text-orange-500 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" 
                                 viewBox="0 0 24 24">
                                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                            </svg>
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center text-white hover:text-orange-500 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Iconos (Móvil) -->
        <div class="flex items-center md:hidden relative z-20">
            <!-- Carrito Móvil -->
            <button id="cart-btn-mobile" class="relative text-white hover:text-orange-500 mr-4 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 3h2l.4 2m.6 3h14l-1.68 7H7.88m0 0L6.2 8H20M7.88 21a2 2 0 100-4 2 2 0 000 4z" />
                </svg>
                <span id="cartItemCountMobile"
                      class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                    {{ $cartCount }}
                </span>
            </button>
            <!-- Menú Hamburguesa -->
            <button id="menu-btn" class="text-white hover:text-orange-500 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>
</div>

@if(Auth::check())
<div id="user-dropdown"
     class="glass-dropdown hidden top-20 right-8 z-50 text-white py-2"
>
    <div class="px-4 py-2 text-sm font-semibold border-b border-white/20 flex items-center space-x-2">
        <span class="material-symbols-rounded text-orange-500">support</span>
        <span>Soporte 24/7</span>
    </div>

    <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2 text-sm hover:bg-white/10 transition-colors space-x-2">
        <span class="material-symbols-rounded text-orange-500">shopping_bag</span>
        <span>Mis Pedidos</span>
    </a>

    <div class="border-t border-white/20 my-2"></div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                class="flex items-center w-full text-left px-4 py-2 text-sm hover:bg-white/10 transition-colors space-x-2">
            <span class="material-symbols-rounded text-orange-500">logout</span>
            <span>Cerrar Sesión</span>
        </button>
    </form>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('search');
        const searchContainer = document.querySelector('.search-container');
        const urlParams = new URLSearchParams(window.location.search);

        if (urlParams.has('search_expanded')) {
            searchContainer.classList.add('expanded');
            searchInput.focus();
        }

        searchInput.addEventListener('focus', () => {
            const gameList = document.getElementById('game-list');
            if (!gameList) {
                const searchUrl = '{{ route("games") }}?search_expanded=1';
                window.location.href = searchUrl;
            }
        });

        const userMenuBtn = document.getElementById('user-menu-btn');
        const userDropdown = document.getElementById('user-dropdown');

        if (userMenuBtn && userDropdown) {
            userMenuBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                // Alternar clase hidden en el dropdown
                userDropdown.classList.toggle('hidden');
            });

            window.addEventListener('click', (e) => {
                if (!userMenuBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        }
    });
</script>
