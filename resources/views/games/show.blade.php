@php
    $navbarAlwaysScrolled = true;
    $navbarScrolledBackground = 'bg-black/60 backdrop-blur-md';
@endphp

@extends('layouts.app')

@section('title', $game->name . ' - DigitalPlay')

@section('header-banner')
    @include('components.header-banner', [
        'backgroundImage' => asset('uploads/' . $game->image),
        'showContent' => false,
        'blur' => true,
        'blurLevel' => 'blur-lg',
    ])
@endsection

@section('content')
    <!-- Contenedor Principal -->
    <div id="game-show-page" class="relative">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-screen-xl">
            <!-- Agregamos max-w-screen-xl para limitar el ancho máximo -->
            <!-- Sección de Detalles del Juego con superposición sobre el header-banner -->
            <div
                class="game-details flex flex-col lg:flex-row items-start p-6 lg:p-12 gap-6 lg:gap-8 w-full -mt-40 md:-mt-52 lg:-mt-64 relative z-10">
                <!-- Imagen del Juego -->
                <div class="game-image w-full lg:w-1/2">
                    <img alt="{{ $game->name }}" loading="lazy"
                        class="w-full rounded-lg h-auto object-cover transition-transform duration-300 hover:scale-105"
                        src="{{ asset('uploads/' . $game->image) }}" />
                </div>

                <!-- Información del Juego -->
                <div class="game-info w-full lg:w-1/2 flex flex-col justify-center">
                    <div class="bg-white bg-opacity-20 backdrop-blur-md rounded-[1rem] p-7 shadow-xl flex flex-col">
                        <h1 class="text-3xl text-white font-extrabold mb-3 text-center">{{ $game->name }}</h1>

                        <!-- Precio y descuento -->
                        <div class="flex items-center justify-center mb-3">
                            @if ($game->discounted_price)
                                <div class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold mr-2">
                                    -{{ round((($game->discounted_price - $game->price) / $game->discounted_price) * 100) }}%
                                </div>
                                <span
                                    class="text-gray-200 line-through mr-2 text-base">${{ number_format($game->discounted_price, 2) }}</span>
                            @endif
                            <span class="text-2xl text-white font-bold">${{ number_format($game->price, 2) }}</span>
                        </div>

                        <!-- Consolas asignadas al juego -->
                        <div class="text-center">
                            <i class="fas fa-gamepad text-blue-400"></i>
                            <span class="text-gray-200 mt-2">:
                                @if ($game->consoles->count())
                                    {{ $game->consoles->pluck('name')->implode(', ') }}
                                @else
                                    No asignado
                                @endif
                            </span>
                        </div>

                        <!-- Información adicional condensada -->
                        <div class="additional-info mt-4 flex items-center justify-center space-x-6 text-gray-200">
                            <div class="flex items-center">
                                <i class="fas fa-folder-open text-orange-400 mr-1"></i>
                                <span>{{ $game->category->name }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-green-400 mr-1"></i>
                                <span>{{ \Carbon\Carbon::parse($game->release_date)->format('d M, Y') }}</span>
                            </div>
                        </div>

                        <!-- Botón y estado de stock -->
                        <div class="mt-5 flex flex-col items-center">
                            <!-- Botón de agregar al carrito -->
                            <button data-id="{{ $game->id }}"
                                class="add-to-cart-btn bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-3 rounded-full transition-all duration-300 flex items-center justify-center w-full max-w-xs
                                @if ($game->stock <= 0) opacity-50 cursor-not-allowed @else hover:from-red-600 hover:to-orange-600 @endif"
                                @if ($game->stock <= 0) disabled @endif>
                                <i class="fas fa-shopping-cart mr-2"></i> Agregar al carrito
                            </button>

                            <!-- Estado de stock con icono -->
                            <div class="stock-status mt-3 flex items-center">
                                @if ($game->stock > 0)
                                    <i class="fas fa-check-circle text-green-400 mr-2"></i>
                                    <span class="text-gray-200 text-sm">En stock</span>
                                @else
                                    <i class="fas fa-times-circle text-red-400 mr-2"></i>
                                    <span class="text-gray-200 text-sm">Agotado</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección Inferior: Descripción y Comentarios -->
            <div class="game-extra mt-0 lg:mt-4 mb-12 space-y-8">
                <!-- Descripción -->
                <div
                    class="description bg-white bg-opacity-20 backdrop-blur-md rounded-[1rem] shadow-xl p-6 lg:p-8 max-w-5xl mx-auto">
                    <!-- Icono y Título de Descripción -->
                    <div class="flex items-center mb-4">
                        <div class="bg-orange-500 text-white rounded-full p-3 shadow-md mr-3">
                            <i class="fas fa-info-circle fa-lg"></i>
                        </div>
                        <h2 class="text-xl lg:text-2xl text-white font-bold">Descripción</h2>
                    </div>
                    <p class="text-gray-200 text-sm lg:text-base leading-relaxed">{{ $game->description }}</p>
                </div>

                <!-- Comentarios -->
                <div
                    class="comments bg-white bg-opacity-20 backdrop-blur-md rounded-[1rem] shadow-xl p-6 lg:p-8 max-w-5xl mx-auto">
                    <!-- Icono y Título de Comentarios -->
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-500 text-white rounded-full p-3 shadow-md mr-3">
                            <i class="fas fa-comments fa-lg"></i>
                        </div>
                        <h2 class="text-xl lg:text-2xl text-white font-bold">Comentarios</h2>
                    </div>
                    <!-- Comentarios Dinámicos -->
                    @if ($game->comments->count())
                        <ul class="space-y-6">
                            @foreach ($game->comments as $comment)
                                <li
                                    class="bg-white bg-opacity-10 p-5 rounded-[1.5rem] hover:bg-opacity-20 transition-colors duration-300">
                                    <div class="flex items-center mb-3">
                                        @if ($comment->user_image)
                                            <img src="{{ asset('uploads/' . $comment->user_image) }}"
                                                alt="{{ $comment->user_name }}"
                                                class="w-10 h-10 rounded-full mr-3 border-2 border-blue-500">
                                        @else
                                            <div
                                                class="w-10 h-10 rounded-full mr-3 bg-blue-500 flex items-center justify-center text-white font-bold text-lg">
                                                {{ strtoupper(substr($comment->user_name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <h3 class="text-white font-semibold text-base">{{ $comment->user_name }}</h3>
                                            <div class="flex items-center text-yellow-400 text-sm">
                                                @for ($i = 0; $i < 5; $i++)
                                                    @if ($i < $comment->rating)
                                                        <i class="fas fa-star"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-200 text-sm">{{ $comment->review }}</p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-400 text-base text-center">No hay comentarios aún. Sé el primero en comentar.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Estilos Personalizados -->
    <style>
        /* Asegurarse de que el encabezado tenga un z-index menor */
        .header-banner {
            position: relative;
            z-index: 1;
            /* Valor menor que el contenedor principal */
        }

        /* Mejoras adicionales para UI/UX */

        /* Botón de agregar al carrito */
        .add-to-cart-btn {
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-position 0.3s ease;
            background-size: 200% 200%;
        }

        .add-to-cart-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.3);
        }

        /* Igualar la altura de las columnas */
        .game-details {
            align-items: flex-start;
            /* Usamos flex-start para evitar que los elementos se estiren verticalmente */
        }

        .game-image img {
            height: auto;
            /* Ajustar la altura automáticamente */
        }

        .game-info {
            display: flex;
            flex-direction: column;
        }

        /* Scrollbar Personalizada para Comentarios */
        .comments ul::-webkit-scrollbar {
            width: 8px;
        }

        .comments ul::-webkit-scrollbar-track {
            background: transparent;
        }

        .comments ul::-webkit-scrollbar-thumb {
            background-color: #F97316;
            /* Orange-500 */
            border-radius: 4px;
            border: 2px solid transparent;
            background-clip: content-box;
        }

        /* Ajustar margen inferior de la sección extra */
        .game-extra {
            margin-bottom: 4rem;
            /* Agregar más espacio antes del footer */
            margin-top: 0;
            /* Reducir el margen superior */
        }

        /* Mejorar responsividad */
        @media (max-width: 1024px) {
            .game-details {
                flex-direction: column;
                margin-top: -10rem;
                /* Ajustar margen superior en pantallas más pequeñas */
            }

            .game-info {
                margin-top: 1rem;
            }
        }
    </style>
@endsection
