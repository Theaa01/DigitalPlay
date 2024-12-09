<!-- resources/views/partials/cart-items.blade.php -->
@if(!empty($cart))
    @foreach($cart as $id => $item)
        <div 
            class="cart-item flex items-start p-4 rounded-lg shadow-custom-sm" 
            data-original-price="{{ isset($item['discounted_price']) ? $item['discounted_price'] : $item['price'] }}" 
            data-price="{{ $item['price'] }}" 
            data-quantity="{{ $item['quantity'] }}">
            
            <!-- Imagen del Producto -->
            <div class="w-40 h-24 flex-shrink-0 overflow-hidden rounded-lg bg-gray-700">
                <img src="{{ asset('uploads/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
            </div>
            
            <!-- Información del Producto -->
            <div class="ml-4 flex-1 flex flex-col justify-between">
                <div>
                    <h3 class="text-white font-medium text-base truncate" title="{{ $item['name'] }}">{{ $item['name'] }}</h3>
                    
                    <!-- Precio y Descuento -->
                    <div class="flex items-center mt-1">
                        <!-- Precio Actual -->
                        <span class="text-[#FFA500] font-medium text-sm item-price">
                            ${{ number_format($item['price'], 2) }}
                        </span>
                        
                        <!-- Precio Descontado (si existe y es mayor que el precio actual) -->
                        @if(isset($item['discounted_price']) && $item['discounted_price'] > $item['price'])
                            <span class="text-gray-400 line-through text-xs ml-2">
                                ${{ number_format($item['discounted_price'], 2) }}
                            </span>
                            
                            <!-- Mostrar porcentaje de descuento en un rectángulo naranja con texto blanco -->
                            @php
                                $discountPercentage = round((($item['discounted_price'] - $item['price']) / $item['discounted_price']) * 100);
                            @endphp
                            <span class="bg-orange-500 text-white text-xs font-semibold px-2 py-1 rounded-md ml-2">
                                -{{ $discountPercentage }}%
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Cantidad y Eliminar -->
                <div class="flex items-center mt-4">
                    <!-- Selector de Cantidad -->
                    <div class="relative">
                        <button 
                            class="quantity-btn border border-gray-500 bg-[#242424] text-white px-3 py-1 rounded-lg focus:outline-none flex items-center space-x-1" 
                            data-id="{{ $id }}"
                            data-quantity="{{ $item['quantity'] }}">
                            <span class="text-sm">{{ $item['quantity'] }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <!-- Dropdown de Cantidad -->
                        <div 
                            class="quantity-dropdown absolute mt-1 left-0 bg-[#454545] bg-opacity-80 backdrop-blur-md text-white rounded-lg shadow-lg z-10 hidden" 
                            style="display: none;">
                            @for($i = 1; $i <= 10; $i++)
                                <div 
                                    class="quantity-option px-4 py-2 hover:bg-[#484745] cursor-pointer text-sm" 
                                    data-id="{{ $id }}" 
                                    data-quantity="{{ $i }}">
                                    {{ $i }}
                                </div>
                            @endfor
                        </div>
                    </div>
                    
                    <!-- Botón Eliminar -->
                    <button 
                        class="remove-item text-gray-400 hover:text-red-500 focus:outline-none ml-4" 
                        data-id="{{ $id }}">
                        <!-- Ícono de Basura -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12M9 7V5a2 2 0 012-2h2a2 2 0 012 2v2M10 12v6M14 12v6M4 7h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
@else
    <p class="text-white text-center">Tu carrito está vacío.</p>
@endif
