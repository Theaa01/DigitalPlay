

@extends('layouts.app')

@section('title', 'DigitalPlay - Inicio')

@section('header-banner')
    @include('components.header-banner')
@endsection

@section('content')
    <!-- WhatsApp Button -->
    <x-whatsapp-button />

    <!-- Popular Games Section -->
    <section class="popular py-12 bg-gray-900">
        <div class="container mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold mb-8 text-center text-white">Juegos populares</h2>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach($popularGames as $game)
                        <div class="swiper-slide">
                            <x-popular-game :game="$game" />
                        </div>
                    @endforeach
                </div>
                <!-- Swiper Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
                <!-- Swiper Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- All Games Section -->
    <section class="all-games py-12">
        <div class="container mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold mb-8 text-center text-white">Todos los juegos</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($allGames as $game)
                    <x-product-card :game="$game" />
                @endforeach
            </div>
            <div class="mt-8 flex justify-center">
                {{ $allGames->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </section>

    <!-- Comments Section -->
    <section class="feedbacks py-12">
        <div class="container mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold mb-8 text-center text-white">Calificaciones de los clientes</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($comments as $comment)
                    <div class="feedback bg-gray-800 p-6 rounded-lg shadow-lg">
                        <div class="flex items-center mb-4">
                            <img src="{{ asset('uploads/' . $comment->user_image) }}" alt="{{ $comment->user_name }}" class="w-12 h-12 rounded-full mr-4 object-cover">
                            <div>
                                <div class="flex">
                                    @for ($i = 0; $i < 5; $i++)
                                        @if($i < $comment->rating)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.179c.969 0 1.371 1.24.588 1.81l-3.376 2.455a1 1 0 00-.364 1.118l1.286 3.974c.3.921-.755 1.688-1.54 1.118L10 13.347l-3.376 2.455c-.784.57-1.838-.197-1.539-1.118l1.286-3.974a1 1 0 00-.364-1.118L2.98 9.401c-.783-.57-.38-1.81.588-1.81h4.179a1 1 0 00.951-.69l1.286-3.974z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.974a1 1 0 00.95.69h4.179c.969 0 1.371 1.24.588 1.81l-3.376 2.455a1 1 0 00-.364 1.118l1.286 3.974c.3.921-.755 1.688-1.54 1.118L10 13.347l-3.376 2.455c-.784.57-1.838-.197-1.539-1.118l1.286-3.974a1 1 0 00-.364-1.118L2.98 9.401c-.783-.57-.38-1.81.588-1.81h4.179a1 1 0 00.951-.69l1.286-3.974z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <h3 class="text-lg text-white">{{ $comment->game->name }} ({{ $comment->created_at->format('Y') }})</h3>
                            </div>
                        </div>
                        <p class="text-gray-400 mb-4">{{ $comment->review }}</p>
                        <p class="text-gray-500 text-sm">hace {{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="mapa py-12">
        <div class="container mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold mb-8 text-center text-white">Encuéntranos</h2>
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.891343402746!2d-79.022916!3d-8.112545099999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91ad3d3379ba39e9%3A0x8ccda344eab915c2!2sVIDEOJUEGOS%20CARLONCHO!5e0!3m2!1ses-419!2spe!4v1705682072742!5m2!1ses-419!2spe"
                width="100%"
                height="450"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                class="rounded-lg"
            ></iframe>
        </div>
    </section>

    <!-- Búsqueda -->
    <div class="search fixed inset-0 bg-gray-900 bg-opacity-95 flex items-center justify-center text-center text-white hidden">
        <div class="search-close absolute top-5 right-5 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </div>
        <div class="search-content">
            <h1 class="text-2xl mb-4">Escribe el nombre del videojuego que deseas buscar.</h1>
            <input type="text" id="searchInput" placeholder="Buscar" class="mt-4 p-2 rounded-full w-80 text-black">
            <div class="results mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4"></div>
        </div>
    </div>

    <!-- Alert -->
    <div id="customAlert" class="custom-alert fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow-lg hidden">
        <!-- Mensaje de alerta -->
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/pagination.js') }}"></script>
@endsection