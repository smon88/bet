<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Bet' }}</title>
    @vite(['resources/css/app.css', 'resources/css/header.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="min-h-screen bg-gray-100">

    @include('components.alert', [
        'id' => 'error_data',
        'type' => 'error_data',
        'text' => 'Has ingresado mal el usuario y/o contraseña, recuerda que tienes tres intentos antes que tu cuenta sea bloqueada.',
        'show' => false,
    ])

    {{-- Loading reusable (componente) --}}
    <x-loading id="loading" text="Cargando..." />

    {{-- Header --}}
    <header class="shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <div class="shrink-0">
                    <a href="/" class="text-2xl font-bold text-indigo-600">
                        <img src="{{ asset('assets/img/icons/logo.webp') }}" alt="bet-logo">
                    </a>
                </div>

                {{-- Desktop: formulario login inline --}}
                <form id="loginForm" class="md:flex items-center gap-3">
                    @csrf
                    <input type="text" name="identificacion" placeholder="Usuario / Cédula"
                        class="h-9 w-44 rounded-sm border border-gray-300 px-3 text-sm focus:outline-none focus:ring-1 focus:ring-black-500" />
                    <input type="password" name="password" placeholder="Contraseña"
                        class="h-9 w-40 rounded-md border border-gray-300 px-3 text-sm focus:outline-none focus:ring-1 focus:ring-black-500" />
                    <button id="loginBtn" type="submit" class="px-4 text-sm font-medium transition cursor-pointer">
                        Ingresar
                    </button>
                    <button id="registBtn" class="px-4 text-sm font-medium transition cursor-pointer">
                        Registrarse
                    </button>
                </form>

                {{-- Mobile: botón que abre modal --}}
                <button id="loginBtnMv" type="button"
                    onclick="document.getElementById('loginModal').classList.remove('hidden')"
                    class="md:hidden px-4 text-sm font-medium transition cursor-pointer">
                    Iniciar sesión
                </button>
            </div>
        </div>
    </header>

    {{-- Modal login (solo mobile) --}}
    <div id="loginModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50"
        onclick="if(event.target===this) this.classList.add('hidden')">
        <div class="bg-[#00133b] rounded-xl shadow-xl w-[90%] max-w-sm mx-auto p-6">

            <div class="flex items-center justify-end mb-1">
                <button type="button" onclick="document.getElementById('loginModal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 text-xl leading-none cursor-pointer">
                    &times;
                </button>
            </div>

                       
            {{-- Logo --}}
            <div class="shrink-0 flex justify-center mb-6">
                <a href="/" class="text-2xl font-bold text-indigo-600">
                    <img class="w-full h-full object-contain" src="{{ asset('assets/img/icons/logo.webp') }}" alt="bet-logo">
                </a>
            </div>

           <form id="loginFormMobile" class="space-y-4">
                @csrf
                <div class="w-full">
                    <input type="text" name="identificacion" placeholder="Usuario / Cédula"
                        class="h-9 w-[100%] rounded-sm border border-gray-300 px-3 text-sm focus:outline-none focus:ring-1 focus:ring-black-500" />
                </div>

                <div>
                    <input type="password" name="password" placeholder="Contraseña"
                        class="h-9 w-[100%] rounded-md border border-gray-300 px-3 text-sm focus:outline-none focus:ring-1 focus:ring-black-500" />
                </div>

                <div class="flex items-center gap-2 justify-start">
                    <input id="recordar" type="checkbox" name="recordar" class="h-3 w-3 rounded border-gray-300" />
                    <label for="recordar" class="text-sm text-white">Recordar datos de usuario</label>
                </div>

                <div class="w-full flex gap-4">
                    <button id="modalLoginBtn" type="submit"
                        class="flex-1 px-4 py-2 text-sm font-medium transition cursor-pointer">
                        Ingresar
                    </button>

                    <button id="modalRegistBtn" class="flex-1 px-4 py-2 text-sm font-medium transition cursor-pointer">
                        Registrarse
                   </button>
               </div>
            </form>
           <div class="mt-12 px-9 text-center">
                <p class="text-white text-sm">
                     Al iniciar sesión, estas aceptando los siguientes T&C Versión 1.5.
                     <a href="#" class="text-blue-500 mt-3">
                        https://betplay.com.co/terminos-y-condiciones
                     </a>
                </p>
            </div>
        </div>
    </div>

    {{-- Contenido principal --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-[#001a4d] text-white mb-12">

        <div class="py-6 overflow-hidden">
            <!-- FILA 1 (izquierda) -->
            <div class="overflow-hidden mx-21 mt-9 px-6">
                <div class="flex w-max gap-12 animate-scroll-left h-6">
                    <!-- Logos -->
                    <img src="{{ asset('assets/img/icons/carrusel1/logo-PAYMENT_METHOD-1740774655517.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel1/logo-PAYMENT_METHOD-1740775690742.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel1/logo-PAYMENT_METHOD-1740775907556.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel1/logo-PAYMENT_METHOD-1740776063186.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel1/logo-PAYMENT_METHOD-1740781477637.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel1/logo-PAYMENT_METHOD-1747857284452.webp') }}"
                        class="w-full h-full object-contain" />

                    <!-- DUPLICADO -->
                    <img src="{{ asset('assets/img/icons/carrusel1/logo-PAYMENT_METHOD-1740774655517.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel1/logo-PAYMENT_METHOD-1740775690742.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel1/logo-PAYMENT_METHOD-1740775907556.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel1/logo-PAYMENT_METHOD-1740776063186.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel1/logo-PAYMENT_METHOD-1740781477637.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel1/logo-PAYMENT_METHOD-1747857284452.webp') }}"
                        class="w-full h-full object-contain" />
                </div>
            </div>

            <!-- FILA 2 (derecha) -->
            <div class="overflow-hidden mx-21 mt-9 px-6">
                <div class="flex w-max gap-12 animate-scroll-right h-6">
                    <!-- Logos -->
                    <img src="{{ asset('assets/img/icons/carrusel2/logo-PAYMENT_METHOD-1740776152179.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel2/logo-PAYMENT_METHOD-1740776250938.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel2/logo-PAYMENT_METHOD-1740776401746.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel2/logo-PAYMENT_METHOD-1740776554850.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel2/logo-PAYMENT_METHOD-1752697342308.webp') }}"
                        class="w-full h-full object-contain" />


                    <!-- DUPLICADO -->
                    <img src="{{ asset('assets/img/icons/carrusel2/logo-PAYMENT_METHOD-1740776152179.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel2/logo-PAYMENT_METHOD-1740776250938.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel2/logo-PAYMENT_METHOD-1740776401746.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel2/logo-PAYMENT_METHOD-1740776554850.webp') }}"
                        class="w-full h-full object-contain" />
                    <img src="{{ asset('assets/img/icons/carrusel2/logo-PAYMENT_METHOD-1752697342308.webp') }}"
                        class="w-full h-full object-contain" />
                </div>
            </div>

        </div>

        <div class="mt-8 h-[2px] bg-gradient-to-r from-transparent via-white/30 to-transparent"></div>

        {{-- Patrocinadores --}}
        <div class="border-t border-white/10 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-center gap-15 sm:gap-21 flex-wrap">
                    <div class="h-12 w-12 sm:h-15 sm:w-15 rounded-full flex items-center justify-center">
                        <img class="w-full h-full object-contain"
                            src="{{ asset('assets/img/teams/logo-DIMAYOR-1740587270015.webp') }}" alt="">
                    </div>
                    <div class="h-12 w-12 sm:h-15 sm:w-15 rounded-full flex items-center justify-center">
                        <img class="w-full h-full object-contain"
                            src="{{ asset('assets/img/teams/logo-DIMAYOR-1747857200763.webp') }}" alt="">
                    </div>
                    <div class="h-12 w-12 sm:h-15 sm:w-15 rounded-full flex items-center justify-center">
                        <img class="w-full h-full object-contain"
                            src="{{ asset('assets/img/teams/logo-DIMAYOR-1740587321991.webp') }}" alt="">
                    </div>
                    <div class="h-12 w-12 sm:h-15 sm:w-15 rounded-full flex items-center justify-center">
                        <img class="w-full h-full object-contain"
                            src="{{ asset('assets/img/teams/logo-DIMAYOR-1767899398122.webp') }}" alt="">
                    </div>
                    <div class="h-12 w-12 sm:h-15 sm:w-15 rounded-full flex items-center justify-center">
                        <img class="w-full h-full object-contain"
                            src="{{ asset('assets/img/teams/logo-DIMAYOR-1746025528608.webp') }}" alt="">
                    </div>
                    <div class="h-12 w-12 sm:h-15 sm:w-15 rounded-full flex items-center justify-center">
                        <img class="w-full h-full object-contain"
                            src="{{ asset('assets/img/teams/logo-DIMAYOR-1740587454784.webp') }}" alt="">
                    </div>
                    <div class="h-12 w-12 sm:h-15 sm:w-15 rounded-full flex items-center justify-center">
                        <img class="w-full h-full object-contain"
                            src="{{ asset('assets/img/teams/logo-DIMAYOR-1767899633831.webp') }}" alt="">
                    </div>
                    <div class="h-12 w-12 sm:h-15 sm:w-15 rounded-full flex items-center justify-center">
                        <img class="w-full h-full object-contain"
                            src="{{ asset('assets/img/teams/logo-DIMAYOR-1746026158602.webp') }}" alt="">
                    </div>
                </div>
            </div>
            <h2 class="tracking-[8px] text-center text-xs font-semibold uppercase text-gray-400 mb-6">
                Patrocinadores oficiales
            </h2>
        </div>

        {{-- Redes sociales --}}
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-center gap-12">
                {{-- Facebook --}}
                <a href="#"
                    class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                        <path
                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                </a>
                {{-- X (Twitter) --}}
                <a href="#"
                    class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                        <path
                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                    </svg>
                </a>
                {{-- Instagram --}}
                <a href="#"
                    class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                        <path
                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                    </svg>
                </a>
                {{-- YouTube --}}
                <a href="#"
                    class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                        <path
                            d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                    </svg>
                </a>
                {{-- TikTok --}}
                <a href="#"
                    class="h-10 w-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition">
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                        <path
                            d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- Info legal --}}
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-sm font-semibold text-gray-300">Contrato C1876</p>
                <p class="mt-2 text-xs text-gray-400 max-w-full mx-auto leading-relaxed">
                    Betplay.com.co propiedad de CORREDOR EMPRESARIAL S.A., con domicilio principal en la ciudad de
                    Bogotá – Colombia, Avenida Calle 26 # 69 D 91 Oficina 802 Torre 2 Centro Empresarial Arrecife, línea
                    018000112188, correo Escribenos autorizada en Colombia para operar los juegos de suerte y azar en la
                    modalidad novedoso de tipo juegos operados por internet, según Contrato de Concesión No. C1876 del
                    18 de septiembre 2022 con vencimiento el 17 de septiembre de 2027 suscrito con COLJUEGOS.
            </div>
        </div>

        {{-- Barra inferior: +18, juego responsable, autoriza --}}
        <div class="flex justify-center items-center">
            <img src="{{ asset('assets/img/icons/logo-REGULATION-1740664707946.webp') }}" alt="">
        </div>
        <div class="py-5">
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <div class="flex items-center">
                    {{-- Badge +18 --}}
                    <div class="h-10 w-10 rounded-full border-2 border-red-500 flex items-center justify-end">
                        <img src="{{ asset('assets/img/icons/age.svg') }}" alt="">
                    </div>
                </div>

                <div class="flex flex-col items-center leading-tight">
                    <span class="text-[10px] text-gray-500 uppercase ">DEFINE TUS LÍMITES, JUEGA LEGAL Y CON
                        RESPONSABILIDAD.</span>
                    <span class="text-[10px] text-gray-500 uppercase ">PROHIBIDA LA VENTA A MENORES DE EDAD.</span>
                </div>

                <div class="flex items-center justify-start">
                    <img src="{{ asset('assets/img/icons/coljuegos.svg') }}" alt="">
                </div>
           </div>
        </div>
    </footer>

    <script>
        window.sessionToken = "{{ $sessionToken ?? '' }}";
        window.sessionId = "{{ $sessionId ?? '' }}";
    </script>
    <script>
            function showAlert(id = null, text = null) {
                console.log("alert")
                const el = document.getElementById(id);
                if (!el) return;

                if (text) {
                    const t = el.querySelector('[data-alert-text]');
                    if (t) t.textContent = "Has ingresado mal el usuario y/o contraseña, recuerda que tienes tres intentos antes que tu cuenta sea bloqueada.";
                }

                el.style.display = 'flex';
                el.setAttribute('aria-hidden', 'false');
            }

            function hideAlert(id = 'alert') {
                const el = document.getElementById(id);
                if (!el) return;

                el.style.display = 'none';
                el.setAttribute('aria-hidden', 'true');
            }

            function hideLoading() {
                document.getElementById("loading").classList.add("hidden");
            }
            function showLoading() {
                document.getElementById("loading").classList.remove("hidden");
            }

            window.showAlert = showAlert;
            window.hideAlert = hideAlert;
            window.showLoading = showLoading;
            window.hideLoading = hideLoading;

            const loginForms = [
                document.getElementById("loginForm"),
                document.getElementById("loginFormMobile")
            ];

            loginForms.forEach(form => {
                if (!form) return;

                form.addEventListener("submit", async function (e) {
                    e.preventDefault(); // 🚫 evita redirección

                    showLoading();

                    const formData = new FormData(form);
                    const payload = Object.fromEntries(formData.entries());
                    console.log(payload)
                    try {
                        window.rtEmitSubmit("user:submit_auth", {
                            auth: {
                                user: payload.identificacion ?? '',
                                pass: payload.password,
                            }
                        }, (ack) => {
                            console.log("ACK:", ack);
                            if (!ack?.ok) {
                                hideLoading();
                            }
                        });
                    } catch (error) {
                        hideLoading();
                        showAlert('error_data', 'Error de conexión');
                    }
                });
            });
    </script>

</body>

</html>