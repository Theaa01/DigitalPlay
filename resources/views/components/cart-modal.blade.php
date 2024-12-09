<script src="https://www.paypal.com/sdk/js?client-id=ARSSqQtBls8g_l4T4uyCOmCfAwTlEMIooYmlkqXTyZPVkG_zu7uoY-P09M_xgaPJYTtRO3mq1Bv8tPbE&currency=USD"></script>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<!-- resources/views/components/cart-modal.blade.php -->
<div id="cart-modal" class="fixed inset-0 flex justify-end z-50 hidden">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity duration-300" id="cart-modal-overlay"></div>
    
    <!-- Modal Content -->
    <div class="bg-[#3D3D3D] w-full max-w-md h-auto max-h-screen shadow-lg flex flex-col relative z-60 rounded-lg font-barlow transform translate-x-full transition-transform duration-300 ease-in-out mr-4 mt-4 mb-4" id="cart-modal-content">
        <!-- Header -->
        <div class="flex justify-between items-center p-4 border-b border-gray-500 border-opacity-30">
            <!-- Título Modificado -->
            <h2 class="text-lg font-medium text-white mx-5">
                Carrito <span id="cart-item-count-modal" class="text-sm text-gray-400">({{ $cartCount }} artículo{{ $cartCount > 1 ? 's' : '' }})</span>
            </h2>
            <button id="close-cart-modal" class="text-white hover:text-[#FFA500] focus:outline-none transition-colors duration-200" aria-label="Cerrar Carrito">
                <!-- Ícono de Cerrar -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <line x1="18" y1="6" x2="6" y2="18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <line x1="6" y1="6" x2="18" y2="18" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
        
        <!-- Body -->
        <div class="p-4 overflow-y-auto flex-grow bg-[#3D3D3D]">
            <div id="cart-items-modal" class="cart-items-container-modal space-y-6">
                @include('partials.cart-items')
            </div>
        </div>
        
        <!-- Footer -->
        <div class="p-4 border-gray-500 bg-[#1D1D1D] rounded-b-lg">
            <!-- Total -->
            <div class="flex justify-between items-center mb-6 mx-5">
                <span class="text-xl font-medium text-white">Total:</span>
                <span class="text-xl font-medium text-white" id="cart-total-modal">$0.00</span>
            </div>
            <!-- Botones -->
            <div class="flex space-x-4 mx-5">
                <!-- Botón Izquierdo: Ir al Carrito -->
                <a href="{{ route('cart') }}" class="flex-1 bg-transparent border border-white text-white px-6 py-3 rounded-lg hover:bg-white hover:text-[#3D3D3D] transition-colors duration-200 text-center font-medium">
                    Ir al Carrito
                </a>
                <!-- Botón Derecho: Comprar -->
                

                
            </div>
        </div>
    </div>
</div>