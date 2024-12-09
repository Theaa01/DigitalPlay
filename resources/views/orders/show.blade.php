@extends('layouts.app')

@section('title', 'Detalles de Orden - DigitalPlay')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-24 text-white">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-extrabold text-orange-400">Detalles de la Orden #{{ $order->id }}</h1>
        <a href="{{ route('orders.index') }}"
           class="text-sm font-medium text-white bg-gray-700 hover:bg-gray-600 transition-colors duration-200 px-4 py-2 rounded-md">
           Ver mis pedidos
        </a>
    </div>

    <div class="bg-gray-800/70 rounded-lg shadow-lg">
        <!-- Tabs -->
        <div class="border-b border-gray-700">
            <nav class="flex space-x-4 px-4" aria-label="Tabs">
                <button 
                    class="tab-button relative py-4 px-6 text-sm font-medium text-gray-300 border-b-2 border-transparent hover:text-white hover:border-orange-400 focus:outline-none transition-colors duration-200"
                    data-tab-target="#tab-juegos">
                    <div class="flex items-center space-x-2">
                        <!-- Ícono de "Juegos" -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M9.172 16.172a4 4 0 015.656 0M8.828 7.828a4 4 0 015.656 0M9.172 7.828l5.656 5.656M8.828 16.172l5.656-5.656" />
                        </svg>
                        <span>Juegos</span>
                    </div>
                </button>
                <button 
                    class="tab-button relative py-4 px-6 text-sm font-medium text-gray-300 border-b-2 border-transparent hover:text-white hover:border-orange-400 focus:outline-none transition-colors duration-200"
                    data-tab-target="#tab-info-extra">
                    <div class="flex items-center space-x-2">
                        <!-- Ícono Info Extra -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                          <path stroke-linecap="round" stroke-linejoin="round" 
                                d="M13 16h-1v-4h-1m1-4h.01M21 12A9 9 0 113 12a9 9 0 0118 0z" />
                        </svg>
                        <span>Info Extra</span>
                    </div>
                </button>
            </nav>
        </div>

        <!-- Contenido -->
        <div class="p-8 space-y-8">
            <!-- Tab Juegos -->
            <div id="tab-juegos" class="tab-content hidden">
                <h2 class="text-2xl font-bold text-orange-300 mb-6">Juegos Adquiridos</h2>
                @php
                    $items = json_decode($order->items, true);
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($items as $item)
                        <div class="bg-gray-900/60 p-6 rounded-lg border border-gray-700 hover:border-orange-400 transition-colors duration-200">
                            <div class="w-full h-40 overflow-hidden rounded-md bg-gray-700 mb-4">
                                <img src="{{ asset('uploads/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">{{ $item['name'] }}</h3>
                            <p class="text-gray-300 mb-1">
                                <span class="font-semibold text-white">Cantidad:</span> {{ $item['quantity'] }}
                            </p>
                            <p class="text-gray-300">
                                <span class="font-semibold text-white">Precio:</span> ${{ number_format($item['price'], 2) }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Tab Info Extra -->
            <div id="tab-info-extra" class="tab-content hidden">
                <h2 class="text-2xl font-bold text-orange-300 mb-6">Información Adicional</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-gray-900/60 p-6 rounded-md border border-gray-700">
                        <p class="text-sm text-gray-400 mb-1">ID de Transacción</p>
                        <p class="text-lg font-semibold text-white">{{ $order->transaction_id }}</p>
                    </div>
                    <div class="bg-gray-900/60 p-6 rounded-md border border-gray-700">
                        <p class="text-sm text-gray-400 mb-1">Correo del Pagador</p>
                        <p class="text-lg font-semibold text-white">{{ $order->payer_email }}</p>
                    </div>
                    <div class="bg-gray-900/60 p-6 rounded-md border border-gray-700">
                        <p class="text-sm text-gray-400 mb-1">Estado del Pedido</p>
                        <p class="text-lg font-semibold text-white">{{ $order->status_label }}</p>
                    </div>
                    <div class="bg-gray-900/60 p-6 rounded-md border border-gray-700">
                        <p class="text-sm text-gray-400 mb-1">Fecha de la Orden</p>
                        <p class="text-lg font-semibold text-white">{{ $order->created_at->format('d M, Y') }}</p>
                    </div>
                    <!-- Mostrar el total de la orden -->
                    <div class="bg-gray-900/60 p-6 rounded-md border border-gray-700">
                        <p class="text-sm text-gray-400 mb-1">Total de la Orden</p>
                        <p class="text-lg font-semibold text-white">${{ number_format($order->total_price, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        function showTab(target) {
            tabContents.forEach(tc => tc.classList.add('hidden'));
            document.querySelector(target).classList.remove('hidden');

            tabButtons.forEach(btn => {
                btn.classList.remove('text-white', 'border-orange-400');
                btn.classList.add('text-gray-300');
            });
            const activeBtn = [...tabButtons].find(btn => btn.dataset.tabTarget === target);
            activeBtn.classList.remove('text-gray-300');
            activeBtn.classList.add('text-white', 'border-orange-400');
        }

        // Mostrar el primer tab por defecto
        showTab('#tab-juegos');

        tabButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                showTab(btn.dataset.tabTarget);
            });
        });
    });
</script>
@endsection
