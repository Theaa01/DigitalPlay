<!-- resources/views/cart.blade.php -->
@extends('layouts.app')

@section('title', 'Carrito de Compras')

@section('body-class', 'cart-page') <!-- Clase específica para el carrito -->
<script
    src="https://www.paypal.com/sdk/js?client-id=ARSSqQtBls8g_l4T4uyCOmCfAwTlEMIooYmlkqXTyZPVkG_zu7uoY-P09M_xgaPJYTtRO3mq1Bv8tPbE&currency=USD">
</script>

@section('content')
    <!-- WhatsApp Button -->
    <x-whatsapp-button />

    <!-- Contenedor principal con fondo oscuro y transición suave -->
    <div
        class="max-w-8xl mx-auto py-20 sm:px-8 lg:px-20 mt-16 bg-[#1f1f1f] min-h-screen text-white transition-colors duration-300">
        @if (!empty($cart))
            <!-- Título "Carrito" -->
            <h1 class="text-2xl mb-8 text-center lg:text-left ml-2">Carrito</h1>

            <div class="flex flex-col lg:flex-row lg:space-x-12 cart-container items-start">
                <!-- Lista de Ítems del Carrito -->
                <div class="w-full lg:w-2/3 bg-[#2c2c2c] p-4 lg:p-8 rounded-lg shadow-lg flex flex-col">
                    <div class="space-y-6 flex-grow">
                        <!-- Usar una clase y un ID único para el contenedor de ítems -->
                        <div id="cart-items-main" class="cart-items-container space-y-6 flex-grow">
                            @include('partials.cart-items')
                        </div>
                    </div>
                </div>

                <!-- Sección de Resumen -->
                <div class="w-full lg:w-1/3 bg-[#101010] p-6 rounded-lg shadow-lg flex flex-col sticky top-24">
                    <!-- Título "Resumen" posicionado dentro del contenedor -->
                    <h2 class="text-xl mb-6 text-center lg:text-left">Resumen</h2>

                    <div class="space-y-4 flex-grow">
                        <!-- Precio Oficial -->
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-base">Precio Oficial:</span>
                            <span id="official-price-main"
                                class="text-white text-base">${{ number_format($officialPrice, 2) }}</span>
                        </div>
                        <!-- Descuento -->
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-base">Descuento:</span>
                            <span id="discount-main" class="text-base text-green-400">-
                                ${{ number_format($discount, 2) }}</span>
                        </div>
                        <!-- Subtotal -->
                        <div class="flex justify-between items-center pt-4">
                            <span class="text-lg font-bold text-white">Subtotal:</span>
                            <span id="subtotal-main"
                                class="text-lg font-bold text-white">${{ number_format($subtotal, 2) }}</span>
                        </div>
                    </div><br>
                    <!-- Botón Proceder al Pago -->
                    <div id="paypal-button-container"></div>

                    <!-- Separador con "o" -->
                    <div class="flex items-center my-6">
                        <hr class="flex-grow border-gray-700">
                        <span class="mx-2 text-gray-500">o</span>
                        <hr class="flex-grow border-gray-700">
                    </div>
                    <!-- Enlace Continuar Comprando -->
                    <a href="{{ route('inicio') }}"
                        class="w-full text-gray-400 hover:text-white font-semibold py-3 px-6 text-center transition flex items-center justify-center">
                        <span class="mr-2 text-xl">&lt;</span>
                        Continuar comprando
                    </a>
                </div>
            </div>
        @else
            <div class="flex flex-col items-center justify-center h-full text-center px-4">
                <!-- Icono de Carrito Vacío (Opcional) -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400 mb-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <p class="text-gray-300 text-2xl mb-6">Tu carrito está vacío.</p>
                <a href="{{ route('inicio') }}"
                    class="flex items-center bg-blue-600 text-white px-8 py-4 rounded-full hover:bg-blue-700 transition transform hover:scale-105">
                    Explorar Juegos
                </a>
            </div>
        @endif
    </div>
{{-- Botón PayPal en la vista del carrito --}}
<script>
    paypal.Buttons({
        // Verificar login antes de crear la orden
        createOrder: function(data, actions) {
            // Verificar si el usuario está logueado
            return fetch('/check-login', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.loggedIn) {
                    // Si el usuario no está logueado, redirigir al login y cancelar la creación de la orden
                    window.location.href = '/login'; // Redirige a la página de login
                    return null; // Evita que se cree la orden de PayPal
                }

                // Si está logueado, crear la orden
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '{{ $subtotal }}' // Total del carrito
                        },
                        description: 'Compra de videojuegos - DigitalPlay',
                    }]
                });
            })
            .catch(error => {
                console.error('Error al verificar el login:', error);
            });
        },

        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // Enviar la información del pedido al backend para registrarlo
                return fetch('{{ route('orders.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        transaction_id: details.id,
                        payer_email: details.payer.email_address,
                        total: '{{ $subtotal }}',
                        cart: @json($cart) // Enviar el carrito como JSON
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Limpiar el carrito del cliente
                        localStorage.removeItem('cart'); // Si usas localStorage

                        // Redirigir a la página de la orden utilizando el ID de la orden
                        window.location.href = '/orders/' + data.order_id;
                    } else {
                        console.error('Hubo un problema al registrar tu orden.');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        },

        onError: function(err) {
            console.error('Error de PayPal:', err);
            alert('Ocurrió un error al procesar tu pago. Por favor, inténtalo nuevamente.');
        }
    }).render('#paypal-button-container');
</script>
   

    <!-- CSS Ítems del Carrito -->
    <style>
        /* Título y Eliminar en una fila */
        .cart-page .cart-container .cart-item .flex-1>div:first-child {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }

        /* Título del producto */
        .cart-page .cart-container .cart-item .flex-1>div:first-child h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #FFFFFF;
            margin: 0;
            flex: 2;
        }

        /* Alinear la sección de Resumen al inicio */
        .cart-page .cart-container {
            align-items: flex-start;
        }

        /* --- Nuevos Estilos para Aumentar Tamaño de Precios y Descuentos --- */

        /* Aumentar tamaño del precio actual */
        .cart-page .cart-container .cart-item .item-price {
            font-size: 1rem;
            /* Aumenta según tus necesidades */
        }

        /* Aumentar tamaño del precio descontado */
        .cart-page .cart-container .cart-item span.line-through {
            font-size: 0.8rem;
            /* Aumenta según tus necesidades */
        }

        /* Aumentar tamaño del porcentaje de descuento */
        .cart-page .cart-container .cart-item span.bg-orange-500 {
            font-size: 0.9rem;
            /* Aumenta según tus necesidades */
        }

        /* Responsive: Ajustar tamaños en pantallas pequeñas si es necesario */
        @media (max-width: 1024px) {
            .cart-page .cart-container .cart-item .item-price {
                font-size: 1.25rem;
                /* Ajusta según necesidad */
            }

            .cart-page .cart-container .cart-item span.line-through,
            .cart-page .cart-container .cart-item span.bg-orange-500 {
                font-size: 1rem;
                /* Ajusta según necesidad */
            }

            /* Ajustar la posición del título "Resumen" en pantallas pequeñas */
            .cart-page .cart-container h2 {
                position: static;
                transform: none;
                margin-bottom: 1rem;
            }

            /* Evitar que la sección de resumen sea sticky en pantallas pequeñas */
            .cart-page .cart-container .w-full.lg\:w-1/3 {
                position: static;
            }
        }

        /* --- Estilos Personalizados para Símbolos ">" y "<" --- */

        /* Estilo para el símbolo ">" en el botón */
        .cart-page .cart-container button#proceed-to-checkout span.text-xl {
            /* Aumentar el tamaño del símbolo ">" */
            font-size: 1.25rem;
        }

        /* Estilo para el símbolo "<" en el enlace */
        .cart-page .cart-container a span.text-xl {
            /* Aumentar el tamaño del símbolo "<" */
            font-size: 1.25rem;
        }
    </style>
@endsection
