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
        <div class="flex justify-between items-center transition-all duration-300 ease-in-out group-hover:scale-110">
            <!-- Nombre del juego -->
            <div class="text-gray-200 truncate w-1/2">
                {{ $game->name }}
            </div>
            <!-- Precios -->
            <div class="text-lg">
                <!-- Si hay un precio con descuento -->
                @if ($game->discounted_price)
                    <div class="flex items-center">
                        <!-- Precio con descuento (price) -->
                        <span class="text-white font-bold">${{ number_format($game->price, 2) }}</span>
                    </div>
                @else
                    <!-- Si no hay descuento, solo mostrar el precio actual -->
                    <span class="text-white font-bold">${{ number_format($game->price, 2) }}</span>
                @endif
            </div>
        </div>
    </div>
@endforeach
@if ($games->isEmpty())
    <div class="text-center text-gray-400 mt-6">
        <p>No se encontraron juegos.</p>
    </div>
@endif
