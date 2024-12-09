<!-- resources/views/auth/register.blade.php -->
@php
    $navbarAlwaysScrolled = true;
    $navbarScrolledBackground = 'bg-black/60 backdrop-blur-md';
@endphp

@extends('layouts.app')

@section('title', 'Regístrate - Digital Play')

@section('content')
<!-- Contenedor Principal con Padding para el Navbar -->
<div class="flex flex-col md:flex-row min-h-screen pt-20">
    <!-- Sección Izquierda: Formulario de Registro -->
    <div class="md:w-1/2 w-full bg-gray-900 flex items-center justify-center p-8">
        <!-- Contenedor del Formulario -->
        <div class="w-full max-w-md">
            <!-- Título -->
            <h2 class="text-3xl font-semibold text-white text-center mb-6">Regístrate</h2>

            <!-- Inicio de Registro con Google (Opcional) -->
            <a href="{{ route('goo_auth.redirect') }}" class="flex items-center mb-4 justify-center w-full gap-2 text-base font-medium py-2 rounded-md text-gray-800 bg-white hover:bg-gray-100 transition">
                <img src="https://cdn1.iconfinder.com/data/icons/google-s-logo/150/Google_Icons-09-512.png" alt="Google" class="w-6 h-6" />
                Regístrate con Google
            </a>

            <!-- Separador -->
            <div class="flex items-center justify-center mb-6">
                <hr class="flex-grow border-gray-600" />
                <span class="text-gray-400 mx-2">o</span>
                <hr class="flex-grow border-gray-600" />
            </div>

            <!-- Formulario de Registro -->
            <form method="POST" action="{{ route('register') }}" class="w-full">
                @csrf

                <!-- Nombre y Apellido -->
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mb-4">
                    <!-- Nombre -->
                    <div class="relative w-full">
                        <input type="text" name="name" placeholder="Ingrese su nombre"
                            class="w-full bg-gray-700 text-white placeholder-gray-400 px-4 py-3 pl-12 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition"
                            value="{{ old('name') }}" required autofocus>
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="material-symbols-rounded">person</i>
                        </span>
                        @error('name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Apellido -->
                    <div class="relative w-full">
                        <input type="text" name="last_name" placeholder="Ingrese su apellido" 
                            class="w-full bg-gray-700 text-white placeholder-gray-400 px-4 py-3 pl-12 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition"
                            value="{{ old('last_name') }}" required>
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="material-symbols-rounded">person</i>
                        </span>
                        @error('last_name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Correo Electrónico -->
                <div class="relative mb-4">
                    <input type="email" name="email" placeholder="Ingrese un correo"
                        class="w-full bg-gray-700 text-white placeholder-gray-400 px-4 py-3 pl-12 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition"
                        value="{{ old('email') }}" required>
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <i class="material-symbols-rounded">mail</i>
                    </span>
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Contraseña y Confirmación de Contraseña -->
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mb-4">
                    <!-- Contraseña -->
                    <div class="relative w-full">
                        <input type="password" name="password" id="password" placeholder="********"
                            class="w-full bg-gray-700 text-white placeholder-gray-400 px-4 py-3 pl-12 pr-10 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition"
                            required>
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="material-symbols-rounded">lock</i>
                        </span>
                        <button type="button" onclick="togglePassword('password', 'toggle-password-icon')"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 focus:outline-none" aria-label="Mostrar/Ocultar Contraseña">
                            <span id="toggle-password-icon" class="material-symbols-rounded">
                                visibility
                            </span>
                        </button>
                        @error('password')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirmación de Contraseña -->
                    <div class="relative w-full">
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="********"
                            class="w-full bg-gray-700 text-white placeholder-gray-400 px-4 py-3 pl-12 pr-10 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition"
                            required>
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="material-symbols-rounded">lock</i>
                        </span>
                        <button type="button" onclick="togglePassword('password_confirmation', 'toggle-confirm-password-icon')"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 " aria-label="Mostrar/Ocultar Contraseña">
                            <span id="toggle-confirm-password-icon" class="material-symbols-rounded">
                                visibility
                            </span>
                        </button>
                        @error('password_confirmation')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Fecha de Nacimiento y País -->
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4 mb-4">
                    <!-- Fecha de Nacimiento -->
                    <div class="relative w-full">
                        <input type="date" name="birthday"
                            class="w-full bg-gray-700 text-white px-4 py-3 pl-14 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition"
                            required />
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <i class="material-symbols-rounded">calendar_today</i>
                        </span>
                        @error('birthday')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- País -->
                    <div class="relative w-full">
                        <select name="pais"
                            class="w-full bg-gray-700 text-white px-4 py-3 pr-12 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500 transition">
                            <option value="" disabled selected>País</option>
                            <option value="Argentina">Argentina</option>
                            <option value="Bolivia">Bolivia</option>
                            <option value="Brasil">Brasil</option>
                            <option value="Chile">Chile</option>
                            <option value="Colombia">Colombia</option>
                            <option value="Ecuador">Ecuador</option>
                            <option value="Guyana">Guyana</option>
                            <option value="Paraguay">Paraguay</option>
                            <option value="Perú">Perú</option>
                            <option value="Surinam">Surinam</option>
                            <option value="Uruguay">Uruguay</option>
                            <option value="Venezuela">Venezuela</option>
                        </select>

                        @error('pais')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Términos y Condiciones -->
                <div class="mb-6 flex items-center">
                    <input class="mr-2 h-4 w-4 text-orange-600 bg-gray-700 border-gray-600 rounded focus:ring-orange-500" type="checkbox" name="terms" id="terms" required>
                    <label class="text-gray-400" for="terms">
                        Estoy de acuerdo con los
                        <a class="text-orange-500 hover:underline" href="#">
                            Términos
                        </a>
                        y
                        <a class="text-orange-500 hover:underline" href="#">
                            Políticas de Privacidad
                        </a>
                    </label>
                </div>

                <!-- Botones -->
                <div class="mb-6">
                    <button type="submit" class="w-full bg-orange-600 text-white py-3 rounded-md hover:bg-orange-700 transition">
                        Aceptar
                    </button>
                </div>
                <div class="text-center">
                    <a class="text-gray-400 hover:text-orange-500" href="{{ route('login') }}">
                        « Atrás
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Sección Derecha: Imagen (Visible en Pantallas Medianas y Mayores) -->
    <div class="hidden md:block md:w-1/2 bg-gray-900 relative">
        <img alt="Register Image" class="object-cover h-full w-full" src="{{ asset('uploads/login-image.jpg') }}" />
        <!-- Botón de Cerrar -->
        <button onclick="window.location.href='{{ route('inicio') }}'" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 focus:outline-none" aria-label="Cerrar">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Función para mostrar/ocultar la contraseña
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input.type === "password") {
            input.type = "text";
            icon.textContent = "visibility_off";
        } else {
            input.type = "password";
            icon.textContent = "visibility";
        }
    }
</script>

<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
    display: none;
    }

    input[type="date"] {
    -webkit-appearance: none; /* Para Safari */
    -moz-appearance: none;    /* Para Firefox */
    appearance: none;         /* Para otros navegadores */
    }

    

@endpush

