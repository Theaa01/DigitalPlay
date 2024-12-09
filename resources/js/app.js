// resources/js/app.js

import './bootstrap'; // Asegúrate de que bootstrap.js maneja la configuración de CSRF
import './header';
// import '../css/app.css'; 

// Importar jQuery y asignarlo globalmente
import $ from 'jquery';
window.$ = window.jQuery = $;

// Configurar jQuery para incluir el token CSRF en todas las solicitudes AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Importar Toastr y su CSS
import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

// Importar Swiper
import Swiper from 'swiper/bundle';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

import '../css/app.css';

// Inicializar Toastr
window.toastr = toastr;
// Configuración personalizada de Toastr
toastr.options = {
    "closeButton": false, // Desactiva el botón de cerrar
    "debug": false,
    "newestOnTop": false, // Las nuevas notificaciones no se apilan encima de las antiguas
    "progressBar": false, // Desactiva la barra de progreso
    "positionClass": "toast-bottom-left", // Posición de la notificación
    "preventDuplicates": true, // Evita notificaciones duplicadas
    "onclick": function() {
        $(this).fadeOut(); // Cerrar la notificación al hacer clic
    },
    "showDuration": "300", // Duración de la animación de aparición (ms)
    "hideDuration": "300", // Duración de la animación de desaparición (ms)
    "timeOut": "2000", // Tiempo visible (ms)
    "extendedTimeOut": "1000", // Tiempo adicional si el usuario interactúa (ms)
    "showEasing": "swing", // Efecto de aparición
    "hideEasing": "linear", // Efecto de desaparición
    "showMethod": "fadeIn", // Método de aparición
    "hideMethod": "fadeOut", // Método de desaparición
    "tapToDismiss": true // Permite cerrar la notificación al hacer clic
};

// Función para mostrar notificaciones
function showNotification(message, type = 'success') {
    toastr.remove(); // Eliminar cualquier notificación existente
    switch(type){
        case 'success':
            toastr.success(message);
            break;
        case 'error':
            toastr.error(message);
            break;
        case 'info':
            toastr.info(message);
            break;
        case 'warning':
            toastr.warning(message);
            break;
        default:
            toastr.info(message);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Inicializar Swiper
    const swiper = new Swiper('.mySwiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 2000,  
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        speed: 1000,  
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1280: {
                slidesPerView: 4,
                spaceBetween: 40,
            },
        },
    });

    // Cambiar el color de las flechas a anaranjado
    const nextArrow = document.querySelector('.swiper-button-next');
    const prevArrow = document.querySelector('.swiper-button-prev');
    
    if (nextArrow) {
        nextArrow.style.color = '#FFA500'; // Color anaranjado
    }
    if (prevArrow) {
        prevArrow.style.color = '#FFA500'; // Color anaranjado
    }

    // Manejo del Modal del Carrito
    $('#cart-btn, #cart-btn-mobile').on('click', function() {
        $('#cart-modal').removeClass('hidden');
        $('#cart-modal-content').removeClass('translate-x-full').addClass('translate-x-0');
        loadCart();
    });

    $('#close-cart-modal, #cart-modal-overlay').on('click', function() {
        $('#cart-modal-content').removeClass('translate-x-0').addClass('translate-x-full');
        setTimeout(() => {
            $('#cart-modal').addClass('hidden');
        }, 300); 
    });

    $('#clear-cart').on('click', function() {
        $.ajax({
            url: "/cart/clear",
            method: 'POST',
            beforeSend: function() {
                $('#cart-spinner').removeClass('hidden');
            },
            success: function(response) {
                if(response.success){
                    showNotification(response.success, 'success');
                }

                if(response.cartCount !== undefined){
                    // Actualizar el conteo en el modal y en la vista principal
                    let cartCountText = `(${response.cartCount} artículo${response.cartCount > 1 ? 's' : ''})`;
                    $('#cart-item-count').text(cartCountText);
                    $('#cart-item-count-modal').text(cartCountText);

                    // Actualizar otros elementos que muestran el conteo
                    $('#cartItemCount').text(response.cartCount);
                    $('#cartItemCountMobile').text(response.cartCount);
                }

                if(response.officialPrice !== undefined){
                    $('#official-price-main').text(`$${response.officialPrice}`);
                    $('#official-price').text(`$${response.officialPrice}`); // Si tienes otro ID para la vista principal
                }

                if(response.discount !== undefined){
                    $('#discount-main').text(`- $${response.discount}`);
                    $('#discount').text(`- $${response.discount}`); // Si tienes otro ID para la vista principal
                }

                if(response.subtotal !== undefined){
                    $('#subtotal-main').text(`$${response.subtotal}`);
                    $('#subtotal').text(`$${response.subtotal}`); // Si tienes otro ID para la vista principal
                }

                if(response.total !== undefined){
                    $('#cart-total-modal').text(`$${response.total}`);
                }

                // Actualizar ambos contenedores de ítems
                $('#cart-items-main, #cart-items-modal').html('<p class="text-white text-center">Tu carrito está vacío.</p>');
            },
            complete: function() {
                $('#cart-spinner').addClass('hidden');
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Hubo un error al limpiar el carrito.');
            }
        });
    });

    // Función para cargar los ítems del carrito
    function loadCart() {
        $.ajax({
            url: "/cart/items",
            method: 'GET',
            beforeSend: function() {
                $('#cart-spinner').removeClass('hidden');
            },
            success: function(response) {
                // Actualizar ambos contenedores de ítems
                $('#cart-items-main').html(response);
                $('#cart-items-modal').html(response);

                // Calcular y actualizar los totales
                calculateTotals();
            },
            complete: function() {
                $('#cart-spinner').addClass('hidden');
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Hubo un error al cargar el carrito.');
            }
        });
    }

    // Función para calcular y actualizar los totales
function calculateTotals() {
    let officialPriceMain = 0;
    let discountMain = 0;
    let subtotalMain = 0;

    let officialPriceModal = 0;
    let discountModal = 0;
    let subtotalModal = 0;

    // Calcular para el contenedor principal (cart-items-main)
    $('#cart-items-main .cart-item').each(function() {
        const price = parseFloat($(this).data('price'));
        const quantity = parseInt($(this).data('quantity'));
        const originalPrice = parseFloat($(this).data('original-price')) || price;

        officialPriceMain += (originalPrice * quantity);
        subtotalMain += (price * quantity);

        if (originalPrice > price) {
            discountMain += ((originalPrice - price) * quantity);
        }
    });

    // Calcular para el contenedor del modal (cart-items-modal)
    $('#cart-items-modal .cart-item').each(function() {
        const price = parseFloat($(this).data('price'));
        const quantity = parseInt($(this).data('quantity'));
        const originalPrice = parseFloat($(this).data('original-price')) || price;

        officialPriceModal += (originalPrice * quantity);
        subtotalModal += (price * quantity);

        if (originalPrice > price) {
            discountModal += ((originalPrice - price) * quantity);
        }
    });

    // Formatear los totales a dos decimales
    officialPriceMain = officialPriceMain.toFixed(2);
    discountMain = discountMain.toFixed(2);
    subtotalMain = subtotalMain.toFixed(2);

    officialPriceModal = officialPriceModal.toFixed(2);
    discountModal = discountModal.toFixed(2);
    subtotalModal = subtotalModal.toFixed(2);

    // Actualizar los elementos de resumen en la vista principal
    $('#official-price-main').text(`$${officialPriceMain}`);
    $('#discount-main').text(`- $${discountMain}`);
    $('#subtotal-main').text(`$${subtotalMain}`);

    // Actualizar los elementos de resumen en el modal
    $('#official-price').text(`$${officialPriceModal}`);
    $('#discount').text(`- $${discountModal}`);
    $('#subtotal').text(`$${subtotalModal}`);
    $('#cart-total-modal').text(`$${subtotalModal}`); // Asumiendo que el total es igual al subtotal
}


    // Manejador de eventos para agregar al carrito (Botones "Comprar")
    $(document).on('click', '.add-to-cart-btn', function(e) {
        e.preventDefault();
        var gameId = $(this).data('id');
        addToCart(gameId);
    });

    // Función para agregar un ítem al carrito
    function addToCart(gameId) {
        $.ajax({
            url: `/cart/add/${gameId}`,
            method: 'POST',
            data: {
                quantity: 1
            },
            success: function(response) {
                if(response.success){
                    // Mostrar una notificación de éxito
                    showNotification(response.success, 'success');
                }

                if(response.cartCount !== undefined){
                    // Actualizar el conteo en el modal y en la vista principal
                    let cartCountText = `(${response.cartCount} artículo${response.cartCount > 1 ? 's' : ''})`;
                    $('#cart-item-count').text(cartCountText);
                    $('#cart-item-count-modal').text(cartCountText);

                    // Actualizar otros elementos que muestran el conteo
                    $('#cartItemCount').text(response.cartCount);
                    $('#cartItemCountMobile').text(response.cartCount);
                }

                if(response.officialPrice !== undefined){
                    $('#official-price-main').text(`$${response.officialPrice}`);
                    $('#official-price').text(`$${response.officialPrice}`);
                }

                if(response.discount !== undefined){
                    $('#discount-main').text(`- $${response.discount}`);
                    $('#discount').text(`- $${response.discount}`);
                }

                if(response.subtotal !== undefined){
                    $('#subtotal-main').text(`$${response.subtotal}`);
                    $('#subtotal').text(`$${response.subtotal}`);
                }

                if(response.total !== undefined){
                    $('#cart-total-modal').text(`$${response.total}`);
                }

                // Actualizar la lista de ítems en ambos contenedores
                $('#cart-items-main').html(response.mainCartItems);
                $('#cart-items-modal').html(response.modalCartItems);
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Hubo un error al agregar el juego al carrito.');
            }
        });
    }

    // Función para eliminar un ítem del carrito
    $(document).on('click', '.remove-item', function(e) {
        e.preventDefault(); // Prevenir el comportamiento predeterminado del botón
        const id = $(this).data('id');

        $.ajax({
            url: `/cart/remove/${id}`,
            method: 'DELETE', // Asegúrate de que la ruta en Laravel está configurada para manejar DELETE
            beforeSend: function() {
                $('#cart-spinner').removeClass('hidden');
            },
            success: function(response) {
                if(response.success){
                    showNotification(response.success, 'success');
                }

                if(response.cartCount !== undefined){
                    // Actualizar el conteo en el modal y en la vista principal
                    let cartCountText = `(${response.cartCount} artículo${response.cartCount > 1 ? 's' : ''})`;
                    $('#cart-item-count').text(cartCountText);
                    $('#cart-item-count-modal').text(cartCountText);

                    // Actualizar otros elementos que muestran el conteo
                    $('#cartItemCount').text(response.cartCount);
                    $('#cartItemCountMobile').text(response.cartCount);
                }

                if(response.officialPrice !== undefined){
                    $('#official-price-main').text(`$${response.officialPrice}`);
                    $('#official-price').text(`$${response.officialPrice}`);
                }

                if(response.discount !== undefined){
                    $('#discount-main').text(`- $${response.discount}`);
                    $('#discount').text(`- $${response.discount}`);
                }

                if(response.subtotal !== undefined){
                    $('#subtotal-main').text(`$${response.subtotal}`);
                    $('#subtotal').text(`$${response.subtotal}`);
                }

                if(response.total !== undefined){
                    $('#cart-total-modal').text(`$${response.total}`);
                }

                // Actualizar la lista de ítems en ambos contenedores
                $('#cart-items-main').html(response.mainCartItems);
                $('#cart-items-modal').html(response.modalCartItems);
            },
            complete: function() {
                $('#cart-spinner').addClass('hidden');
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Hubo un error al eliminar el ítem.');
            }
        });
    });

    // Ocultar el dropdown al hacer clic fuera
    $(document).on('click', function() {
        $('.quantity-dropdown').hide();
    });

// Manejo del Dropdown de Cantidad con Posicionamiento Dinámico
$(document).on('click', '.quantity-btn', function(e) {
    e.stopPropagation();
    const dropdown = $(this).siblings('.quantity-dropdown');
    const button = $(this);
    const modalContent = $('#cart-modal-content');

    // Ocultar otros dropdowns
    $('.quantity-dropdown').not(dropdown).hide();

    // Obtener offset del botón y del modal
    const buttonOffset = button.offset();
    const modalOffset = modalContent.offset();
    const modalHeight = modalContent.height();
    const modalScrollTop = modalContent.scrollTop();

    // Calcular posición relativa del botón dentro del modal
    const relativeTop = (buttonOffset.top - modalOffset.top) + modalScrollTop;
    const buttonHeight = button.outerHeight();
    const dropdownHeight = dropdown.outerHeight();

    // Calcular espacio disponible abajo y arriba dentro del modal
    const spaceBelow = modalHeight - (relativeTop + buttonHeight + dropdownHeight);
    const spaceAbove = relativeTop - dropdownHeight;

    if (spaceBelow < 0 && spaceAbove > spaceBelow) {
        // No hay suficiente espacio abajo, posicionar arriba
        dropdown.css({
            'top': 'auto',
            'bottom': '100%',
            'z-index': '1000' // Asegura que el dropdown esté encima de otros elementos
        });
    } else {
        // Posicionar abajo
        dropdown.css({
            'top': '100%',
            'bottom': 'auto',
            'z-index': '1000'
        });
    }

    // Mostrar u ocultar el dropdown
    dropdown.toggle();
});

    // Seleccionar una cantidad
    $(document).on('click', '.quantity-option', function() {
        const id = $(this).data('id');
        const quantity = $(this).data('quantity');
        // Actualizar la cantidad en el servidor
        $.ajax({
            url: `/cart/update-quantity/${id}`, // Asegúrate de que la ruta coincide con 'updateQuantity'
            method: 'POST',
            data: {
                quantity: quantity
            },
            success: function(response) {
                if(response.success){
                    showNotification(response.success, 'success');
                }

                if(response.cartCount !== undefined){
                    // Actualizar el conteo en el modal y en la vista principal
                    let cartCountText = `(${response.cartCount} artículo${response.cartCount > 1 ? 's' : ''})`;
                    $('#cart-item-count').text(cartCountText);
                    $('#cart-item-count-modal').text(cartCountText);

                    // Actualizar otros elementos que muestran el conteo
                    $('#cartItemCount').text(response.cartCount);
                    $('#cartItemCountMobile').text(response.cartCount);
                }

                if(response.officialPrice !== undefined){
                    $('#official-price-main').text(`$${response.officialPrice}`);
                    $('#official-price').text(`$${response.officialPrice}`);
                }

                if(response.discount !== undefined){
                    $('#discount-main').text(`- $${response.discount}`);
                    $('#discount').text(`- $${response.discount}`);
                }

                if(response.subtotal !== undefined){
                    $('#subtotal-main').text(`$${response.subtotal}`);
                    $('#subtotal').text(`$${response.subtotal}`);
                }

                if(response.total !== undefined){
                    $('#cart-total-modal').text(`$${response.total}`);
                }

                // Actualizar la lista de ítems en ambos contenedores
                $('#cart-items-main').html(response.mainCartItems);
                $('#cart-items-modal').html(response.modalCartItems);
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Hubo un error al actualizar la cantidad.');
            }
        });
    });
});
