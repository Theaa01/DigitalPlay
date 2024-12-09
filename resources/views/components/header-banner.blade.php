<!-- resources/views/components/header-banner.blade.php -->
@props(['backgroundImage' => asset('images/bg.jpg'), 'showContent' => true, 'blur' => false])

<header class="bg-cover bg-center flex flex-col relative min-h-[600px] header-diagonal overflow-hidden" style="background-image: url('{{ $backgroundImage }}');">
    <!-- Capa de Desenfoque Condicional -->
    @if($blur)
        <div class="absolute inset-0 bg-cover bg-center filter blur-sm" style="background-image: url('{{ $backgroundImage }}');"></div>
    @endif

    <!-- Overlay para Mejorar la Visibilidad de la Imagen -->
    <div class="absolute inset-0 bg-black opacity-40 z-{{ $blur ? '10' : '0' }}"></div>

    @if ($showContent)
        <!-- Contenido Principal del Header -->
        <div class="container mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8 flex flex-col items-center text-center md:items-start md:text-left text-white mt-32 relative z-20">
            <h1 class="text-5xl font-bold mb-6 drop-shadow-lg">
                Compra tu <span class="text-orange-500">juego</span> <br />
                favorito aquí
            </h1>
            <p class="text-lg mb-12 max-w-md drop-shadow-md">
                Explora un mundo de aventuras y entretenimiento sin límites. 
                En Digital Play, encontrarás los últimos títulos y las ofertas 
                más exclusivas para PC, consolas y dispositivos móviles. 
                ¡Compra fácil, rápido y seguro, y empieza a jugar hoy mismo!
            </p>
            <div class="flex space-x-4 justify-center md:justify-start">
                <a href="#" class="btn-1 bg-transparent border-2 border-orange-500 text-white px-6 py-3 rounded-full hover:bg-orange-500 shadow-md transition">Información</a>
                <a href="#" class="btn-1 bg-transparent border-2 border-orange-500 text-white px-6 py-3 rounded-full hover:bg-orange-500 shadow-md transition">Juegos</a>
            </div>
        </div>
    @endif
</header>

<style>
    .header-diagonal {
        position: relative;
        overflow: hidden;
        clip-path: polygon(0 0, 100% 0, 100% 100%, 0 93%);
        -webkit-clip-path: polygon(0 0, 100% 0, 100% 100%, 0 93%);
    }

    @media (max-width: 768px) {
        .header-diagonal {
            clip-path: none;
        }
    }
</style>
