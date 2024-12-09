@php
    $navbarAlwaysScrolled = true;
    $navbarScrolledBackground = 'bg-black/60 backdrop-blur-md';
@endphp

@extends('layouts.app')

@section('title', 'Mis Órdenes - DigitalPlay')

@section('content')
<main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-24 text-white">
    <h1 class="text-3xl font-extrabold text-center text-orange-400 mb-12">Mis pedidos</h1>

    @if($orders->count() === 0)
        <p class="text-gray-300 text-center">Aún no tienes pedidos realizados.</p>
    @else
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach($orders as $order)
                @php
                    $items = json_decode($order->items, true);
                    $firstItem = $items[0] ?? null;
                    $itemCount = count($items);
                    $additionalCount = $itemCount > 1 ? ($itemCount - 1) : 0;

                    // Determinar el color y etiqueta del estado
                    switch($order->status) {
                        case 'completed':
                            $statusColor = 'bg-green-600';
                            $statusLabel = 'Completada';
                            break;
                        case 'processing':
                            $statusColor = 'bg-yellow-500';
                            $statusLabel = 'En Proceso';
                            break;
                        default:
                            $statusColor = 'bg-gray-500';
                            $statusLabel = ucfirst($order->status);
                            break;
                    }
                @endphp

                <div class="bg-gray-800/70 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start">
                        @if($firstItem && isset($firstItem['image']))
                            <img class="w-16 h-16 rounded-md object-cover mr-4" 
                                 src="{{ asset('uploads/' . $firstItem['image']) }}" 
                                 alt="{{ $firstItem['name'] }}">
                        @else
                            <div class="w-16 h-16 rounded-md bg-gray-700 mr-4 flex items-center justify-center text-gray-300">
                                <!-- Ícono representando órdenes (ejemplo: clipboard-list) -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" 
                                        d="M9 5h6M9 7h6m-3 8a2 2 0 110-4 2 2 0 010 4zm-6 0h6m6 0h.01" />
                                </svg>
                            </div>
                        @endif

                        <div class="flex-1">
                            <h2 class="text-lg font-bold text-white mb-1">Orden #{{ $order->id }}</h2>
                            <div class="flex items-center space-x-2 text-sm">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-white {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                                <span class="text-gray-400">
                                    {{ $itemCount }} {{ Str::plural('Juego', $itemCount) }} 
                                    @if($additionalCount > 0) (+{{ $additionalCount }} más) @endif
                                </span>
                            </div>
                            <p class="text-gray-400 text-sm mt-2">
                                Fecha de compra: {{ $order->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <p class="text-orange-500 font-semibold text-base">
                            ${{ number_format($order->total_price, 2) }}
                        </p>
                        <a href="{{ route('orders.show', $order->id) }}"
                           class="text-sm font-medium text-white bg-orange-500 px-3 py-2 rounded-md hover:bg-orange-600 transition-colors">
                           Ver Detalles
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-12">
            {{ $orders->links() }}
        </div>
    @endif
</main>
@endsection
