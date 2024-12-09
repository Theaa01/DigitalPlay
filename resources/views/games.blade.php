@php
    $navbarAlwaysScrolled = true;
    $navbarScrolledBackground = 'bg-black/60 backdrop-blur-md';
@endphp

@extends('layouts.app')

@section('title', 'DigitalPlay - Catálogo de Juegos')

@section('content')

    <body class="bg-gray-900 text-white">
        <main class="p-10 max-w-7xl mx-auto">
            <!-- Filtros -->
            <form method="GET" action="{{ route('games') }}" id="filter-form" class="mb-6 bg-gray-900 p-4 rounded-lg mt-16">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 justify-center">

                    <!-- Filtrar por Consola -->
                    <div>
                        <label for="console" class="block text-sm font-medium text-gray-300">Sistemas:</label>
                        <select name="console" id="console"
                            class="mt-1 block w-full bg-gray-700 text-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 border-2 hover:border-orange-500">
                            <option value="all">Todos</option>
                            @foreach ($consoles as $console)
                                <option value="{{ $console->id }}"
                                    {{ request('console') == $console->id ? 'selected' : '' }}>
                                    {{ $console->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtrar por Categoría -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-300">Géneros:</label>
                        <select name="category" id="category"
                            class="mt-1 block w-full bg-gray-700 text-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 border-2 hover:border-orange-500">
                            <option value="all">Todos</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ordenar por -->
                    <div>
                        <label for="sort_by" class="block text-sm font-medium text-gray-300">Ordenar por:</label>
                        <select name="sort_by" id="sort_by"
                            class="mt-1 block w-full bg-gray-700 text-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 border-2 hover:border-orange-500">
                            <option value="">Sin Ordenar</option>
                            <option value="discount_desc" {{ request('sort_by') == 'discount_desc' ? 'selected' : '' }}>
                                Mayor Descuento</option>
                            <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Precio:
                                Menor a Mayor</option>
                            <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Precio:
                                Mayor a Menor</option>
                            <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Salida: Más
                                Reciente</option>
                            <option value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>Salida: Más
                                Antigua</option>
                        </select>
                    </div>

                    <!-- Inputs del filtro de precios -->
                    <div class="col-span-2 sm:col-span-1">
                        <form method="GET" action="{{ route('games') }}">
                            <div class="flex items-center gap-2 text-gray-300 font-medium">
                                Entre:
                                <input type="number" name="price_min" id="price_min" min="0" step="0.01"
                                    value="{{ request('price_min') }}"
                                    class="block w-16 bg-gray-700 text-gray-300 text-center rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 border-2 hover:border-orange-500 no-arrows">
                                <span class="text-gray-300 font-medium">y</span>
                                <input type="number" name="price_max" id="price_max" min="0" step="0.01"
                                    value="{{ request('price_max') }}"
                                    class="block w-16 bg-gray-700 text-gray-300 text-center rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 border-2 hover:border-orange-500 no-arrows">
                                $
                                <button type="submit"
                                    class="ml-1 px-4 py-1 bg-orange-500 text-white rounded-md hover:bg-orange-600">
                                    Buscar
                                </button>
                            </div>
                        </form> 
                    <style>
                        /* Ocultar los iconos de incremento y decremento en los inputs de tipo number */
                        .no-arrows::-webkit-outer-spin-button,
                        .no-arrows::-webkit-inner-spin-button {
                            -webkit-appearance: none;
                            margin: 0;
                        }

                        /* También ocultamos los controles en Firefox */
                        .no-arrows[type="number"] {
                            -moz-appearance: textfield;
                        }
                    </style>
                    </div>

                    <!-- Checkbox de Stock -->
                    <div class="mt-4">
                        <label for="in_stock" class="inline-flex items-center text-sm font-medium text-gray-300">
                            <input type="checkbox" name="in_stock" id="in_stock"
                                class="w-5 h-5 rounded border-gray-500 text-orange-500 focus:ring-orange-500 border-2 hover:border-orange-500 bg-black bg-black"
                                {{ request('in_stock') ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-300 font-medium">Stock</span>
                        </label>
                    </div>
                </div>

                <!-- Botón para limpiar filtros (solo visible si hay filtros activos) -->
                @if (
                    (request()->has('category') && request('category') !== 'all') ||
                        (request()->has('console') && request('console') !== 'all') ||
                        (request()->has('sort_by') && request('sort_by') !== '') ||
                        request()->has('in_stock') ||
                        request()->has('price_min') ||
                        request()->has('price_max'))
                    <div class="mt-4 text-center">
                        <a href="{{ route('games') }}"
                            class="px-4 py-2 bg-opacity-0 text-orange-700 rounded-lg hover:text-orange-500">
                            Limpiar Filtros
                        </a>
                    </div>
                @endif
            </form>

            <div class="text-2xl text-white mt-5 mb-10" id="results-count">
                Mostrando <span>{{ $games->total() }}</span> Resultados
            </div>
            

            <!-- Grid de juegos -->
            <div id="game-list" class="grid grid-cols-2 md:grid-cols-3 gap-7 justify-center">
                @foreach ($games as $game)
                    <div class="p-1 rounded relative h-40 group mb-10">
                        <div class="relative">
                            <!-- Porcentaje de descuento (si aplica) -->
                            @if ($game->discounted_price)
                                @php
                                    $discountPercentage = round(
                                        (($game->discounted_price - $game->price) / $game->discounted_price) * 100,
                                    );
                                @endphp
                                <span
                                    class="bg-orange-500 text-white text-md px-1.5 py-0.5 rounded-md absolute bottom-2 left-2 z-10 transition-all duration-300 ease-in-out group-hover:scale-110">
                                    -{{ $discountPercentage }}%
                                </span>
                            @endif
                            <!-- Imagen del juego -->
                            <a href="{{ route('games.show', $game->id) }}">
                                <img alt="{{ $game->name }}"
                                    class="rounded-lg w-full h-40 object-cover mb-2 transform transition-all duration-300 ease-in-out group-hover:scale-110"
                                    src="{{ asset('uploads/' . $game->image) }}" />
                            </a>
                        </div>
                        <!-- Nombre y precio -->
                        <div
                            class="flex justify-between items-center transition-all duration-300 ease-in-out group-hover:scale-110">
                            <div class="text-gray-200 truncate w-1/2">
                                {{ $game->name }}
                            </div>
                            <div class="text-lg">
                                @if ($game->discounted_price)
                                    <div class="flex items-center">
                                        <span class="text-white font-bold">${{ number_format($game->price, 2) }}</span>
                                    </div>
                                @else
                                    <span class="text-white font-bold">${{ number_format($game->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <!-- Paginación -->
            <div class="flex mt-8 mb-6 justify-center">
                {{ $games->appends(request()->query())->links('vendor.pagination.tailwind') }}
            </div>
        </main>

        {{-- Aplicar filtro automáticamente --}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const filterForm = document.getElementById('filter-form');
                const categorySelect = document.getElementById('category');
                const consoleSelect = document.getElementById('console');
                const sortBySelect = document.getElementById('sort_by');
                const stockCheckbox = document.getElementById('in_stock');

                // Enviar el formulario automáticamente al cambiar los selectores
                categorySelect.addEventListener('change', () => {
                    filterForm.submit();
                });
                consoleSelect.addEventListener('change', () => {
                    filterForm.submit();
                });
                sortBySelect.addEventListener('change', () => {
                    filterForm.submit();
                });
                stockCheckbox.addEventListener('change', () => {
                    filterForm.submit();
                });
            });
        </script>
    </body>

@endsection
