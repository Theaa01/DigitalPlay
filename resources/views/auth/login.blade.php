<!-- resources/views/auth/login.blade.php -->

@php
    $navbarAlwaysScrolled = true;
    $navbarScrolledBackground = 'bg-black/60 backdrop-blur-md';
@endphp

@extends('layouts.app')

@section('title', 'Iniciar Sesión - Digital Play')

@section('content')
<!-- Contenedor Principal con Padding para el Navbar -->
<div class="flex flex-col md:flex-row min-h-screen pt-20">
    <!-- Sección Izquierda: Formulario de Login -->
    <div class="md:w-1/2 w-full bg-gray-900 flex items-center justify-center p-8">
        <!-- Contenedor del Formulario -->
        <div class="w-full max-w-md">
            <!-- Título -->
            <h2 class="text-3xl font-semibold text-white text-center mb-8">Iniciar Sesión</h2>

            <!-- Inicio de Sesión con Google (Opcional) -->
            <a href="{{ route('goo_auth.redirect') }}" class="flex items-center mb-6 justify-center w-full gap-2 text-base font-medium py-3 rounded-md text-gray-800 bg-white hover:bg-gray-100 transition">
                <img src="https://cdn1.iconfinder.com/data/icons/google-s-logo/150/Google_Icons-09-512.png" alt="Google" class="w-6 h-6" />
                Inicia sesión con Google
            </a>

            <!-- Separador -->
            <div class="flex items-center justify-center mb-6">
                <hr class="flex-grow border-gray-600" />
                <span class="text-gray-400 mx-2">o</span>
                <hr class="flex-grow border-gray-600" />
            </div>

            <!-- Formulario de Login -->
            <form method="POST" action="{{ route('login') }}" class="w-full">
                @csrf
                <!-- Campo Email -->
                <div class="relative mb-6">
                    <input type="email" name="email" id="email" placeholder="user@example.com" 
                           class="w-full bg-gray-700 text-white placeholder-gray-400 px-4 py-3 pl-12 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition" 
                           value="{{ old('email') }}" required autofocus>
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <i class="material-symbols-rounded">mail</i>
                    </span>
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Campo Contraseña -->
                <div class="relative mb-6">
                    <input type="password" name="password" id="password" placeholder="********" 
                           class="w-full bg-gray-700 text-white placeholder-gray-400 px-4 py-3 pl-12 pr-10 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition" 
                           required>
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <i class="material-symbols-rounded">lock</i>
                    </span>
                    <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 focus:outline-none" aria-label="Mostrar/Ocultar Contraseña">
                        <span id="toggle-password-icon" class="material-symbols-rounded">
                            visibility
                        </span>
                    </button>
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Recuerdame y Olvidé mi Contraseña -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <input class="form-check-input h-4 w-4 text-orange-600 bg-gray-700 border-gray-600 rounded focus:ring-orange-500" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="ml-2 block text-gray-400" for="remember">
                            {{ __('Recuerdame') }}
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-orange-500 hover:underline">
                            {{ __('Olvidaste tu contraseña?') }}
                        </a>
                    @endif
                </div>

                <!-- Botón Iniciar Sesión -->
                <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white py-3 rounded-md hover:from-orange-600 hover:to-orange-700 transition">
                    Iniciar sesión
                </button>
            </form>

            <!-- Enlace Crear Cuenta -->
            <p class="text-center text-gray-400 mt-6">
                ¿Nuevo en Digital Play?
                <a href="{{ route('register') }}" class="text-orange-500 hover:text-orange-600 transition-colors duration-200">Regístrate</a>
            </p>
        </div>
    </div>

    <!-- Sección Derecha: Imagen (Visible en Pantallas Medianas y Mayores) -->
    <div class="hidden md:block md:w-1/2 bg-gray-900 relative">
        <img alt="Login Image" class="object-cover h-full w-full" src="{{ asset('uploads/login-image.jpg') }}" />
        <!-- Botón de Cerrar -->
        <button onclick="window.location.href='{{ route('inicio') }}'" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 focus:outline-none" aria-label="Cerrar">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggle-password-icon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.textContent = 'visibility_off';
        } else {
            passwordInput.type = 'password';
            toggleIcon.textContent = 'visibility';
        }
    }
</script>
@endpush