<!-- resources/views/components/product-card.blade.php -->
<div class="bg-gray-800 rounded-lg shadow-lg overflow-hidden">
    <!-- Contenedor de la Imagen con Hover -->
    <div class="relative group overflow-hidden">
        <a href="{{ route('games.show', $game->id) }}" class="block">
            <img src="{{ asset('uploads/' . $game->image) }}" alt="{{ $game->name }}" class="w-full h-64 object-cover transition-transform duration-300 transform group-hover:scale-105">
            <!-- Hover Overlay Sutil -->
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-opacity duration-300 flex items-center justify-center">
                <span class="text-white text-lg font-medium opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    Ver detalles
                </span>
            </div>
        </a>
    </div>
    <!-- Contenedor de Información y Botón Comprar -->
    <div class="p-4">
        <h3 class="text-xl font-semibold text-white mb-2">{{ $game->name }}</h3>
        <!-- Precio, Precio Descontado y Botón Comprar en una Misma Línea -->
        <div class="flex items-center justify-between">
            <!-- Precio Normal -->
            <div class="text-orange-500 text-lg">
                ${{ number_format($game->price, 2) }}
            </div>
            <!-- Precio Descontado (si existe) -->
            @if($game->discounted_price)
                <div class="text-gray-400 line-through text-sm mx-4">
                    ${{ number_format($game->discounted_price, 2) }}    
                </div>
            @endif

        </div>
    </div>
</div>