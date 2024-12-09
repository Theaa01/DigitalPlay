// resources/js/header.js
document.addEventListener('DOMContentLoaded', function () {
    const menuBtn = document.getElementById('menu-btn');
    const closeBtn = document.getElementById('close-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const navbar = document.getElementById('navbar-container');

    console.log('JavaScript cargado correctamente.');

    // Abrir Menú Móvil
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.remove('translate-x-full');
            console.log('Menú móvil abierto.');
        });
    }

    // Cerrar Menú Móvil
    if (closeBtn && mobileMenu) {
        closeBtn.addEventListener('click', () => {
            mobileMenu.classList.add('translate-x-full');
            console.log('Menú móvil cerrado.');
        });
    }

    // Cerrar Menú al Hacer Clic Fuera del Contenido del Menú
    window.addEventListener('click', (e) => {
        if (e.target === mobileMenu) {
            mobileMenu.classList.add('translate-x-full');
            console.log('Menú móvil cerrado al hacer clic fuera.');
        }
    });

    // Cambiar el fondo del navbar al hacer scroll
    const updateNavbarStyle = () => {
        if (navbar) {
            const alwaysScrolled = navbar.getAttribute('data-always-scrolled') === 'true';
            const scrolledBackground = navbar.getAttribute('data-scrolled-background') || 'bg-black/60 backdrop-blur-md';

            console.log(`alwaysScrolled: ${alwaysScrolled}`);
            console.log(`scrolledBackground: ${scrolledBackground}`);

            if (alwaysScrolled) {
                // Mantener el fondo oscuro transparente desde el inicio
                console.log('Navbar siempre con fondo oscuro transparente. No se aplica cambio al hacer scroll.');
                return;
            }

            if (window.scrollY > 1) {
                navbar.classList.add(...scrolledBackground.split(' '));
                console.log('Clases añadidas al navbar al hacer scroll.');
            } else {
                navbar.classList.remove(...scrolledBackground.split(' '));
                console.log('Clases removidas del navbar al estar en la parte superior.');
            }
        }
    };

    // Inicializar la clase del navbar en caso de que ya se haya hecho scroll al cargar
    updateNavbarStyle();

    // Detectar el evento de scroll
    window.addEventListener('scroll', updateNavbarStyle);

    // Función de búsqueda
    const searchBtn = document.getElementById('search-btn');
    if (searchBtn) {
        searchBtn.addEventListener('click', () => {
            toggleBuscarInput();
            console.log('Botón de búsqueda clicado.');
        });
    }
});

function toggleBuscarInput() {
    // Implementa la lógica para mostrar/ocultar el input de búsqueda
    alert('Funcionalidad de búsqueda aún no implementada.');
}
