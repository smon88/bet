@extends('layout')

@section('content')

    {{-- Barra de Jackpots --}}
    <section class="bg-gradient-to-r from-[#001233] to-[#001845]">
        <div class="max-w-7xl mx-3
                    flex overflow-x-auto 
                    lg:grid lg:grid-cols-[1fr_1fr_1fr_2fr] lg:overflow-visible lg:mx-auto">
            @php
                $jackpots = [
                    ['nombre' => 'Mega', 'target' => 500000000, 'premio' => '$500 Millones', 'color' => '#8EFF00'],
                    ['nombre' => 'Super', 'target' => 20000000, 'premio' => '$20 Millones', 'color' => '#00E836'],
                    ['nombre' => 'Extra', 'target' => 1000000, 'premio' => '$1 Millón', 'color' => '#d4ff00'],
                ];
            @endphp

            @foreach ($jackpots as $jp)
                <a href="#" class="flex flex-col items-center justify-center 
                          py-3 min-w-fit mr-1 sm:min-w-[140px] sm:px-4
                          hover:bg-white/5 transition">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-xl font-bold tracking-wider leading-tight" style="color: {{ $jp['color'] }}">
                            {{ $jp['nombre'] }}
                        </p>
                        <p class="text-xs sm:text-2xl font-bold truncate jackpot-counter leading-tight"
                            style="color: {{ $jp['color'] }}" data-target="{{ $jp['target'] }}">$0</p>
                        <p class="text-[6px] sm:text-[12px] font-bold text-[#8F97A9]">Gana hasta
                            <span>{{ $jp['premio'] }}</span>
                        </p>
                    </div>
                </a>
            @endforeach

            {{-- Progressive Play - imagen --}}
            <div class="p-3 w-fit flex items-center justify-center overflow-hidden hover:opacity-90 transition sm:w-full">
                <img src="{{ asset('assets/img/icons/misterynew2.webp') }}" alt="Progressive Play"
                    class="h-2/3 w-auto object-contain">
            </div>
        </div>
    </section>

    {{-- Slider principal --}}
    <section class="relative w-full h-77% overflow-hidden bg-[#001233]" id="heroSlider">
        {{-- Slides --}}
        <div class="flex transition-transform duration-500 ease-in-out" id="sliderTrack">
            {{-- Slide 1 --}}
            <div class="w-full shrink-0">
                <div
                    class="relative w-full h-[180px] sm:h-[250px] lg:h-[320px] bg-gradient-to-r from-[#002361] to-[#0a3d91] flex items-center justify-center">
                    <img src="{{ asset('assets/img/banners/compressed_6945becbad6b90037ec2d40b.jpg') }}" alt="Promo 1"
                        class="absolute inset-0 w-full h-full object-cover">
                </div>
            </div>
            {{-- Slide 2 --}}
            <div class="w-full shrink-0">
                <div
                    class="relative w-full h-[180px] sm:h-[250px] lg:h-[320px] bg-gradient-to-r from-[#1a0533] to-[#2d1b69] flex items-center justify-center">
                    <img src="{{ asset('assets/img/banners/compressed_69822a7cb6b8838506b687db.jpg') }}" alt="Promo 2"
                        class="absolute inset-0 w-full h-full object-cover">
                </div>
            </div>
            {{-- Slide 3 --}}
            <div class="w-full shrink-0">
                <div
                    class="relative w-full h-[180px] sm:h-[250px] lg:h-[320px] bg-gradient-to-r from-[#0d3320] to-[#1a6b3c] flex items-center justify-center">
                    <img src="{{ asset('assets/img/banners/compressed_698b5173471bd74f2f471073.jpg') }}" alt="Promo 3"
                        class="absolute inset-0 w-full h-full object-cover">
                </div>
            </div>
            {{-- Slide 4 --}}
            <div class="w-full shrink-0">
                <div
                    class="relative w-full h-[180px] sm:h-[250px] lg:h-[320px] bg-gradient-to-r from-[#0d3320] to-[#1a6b3c] flex items-center justify-center">
                    <img src="{{ asset('assets/img/banners/compressed_698b5336cd48e04f2ee4a1b1.jpg') }}" alt="Promo 4"
                        class="absolute inset-0 w-full h-full object-cover">
                </div>
            </div>
        </div>

        {{-- Flecha izquierda --}}
        <button onclick="moveSlider(-1)"
            class="absolute left-3 top-1/2 -translate-y-1/2 z-10 h-10 w-10 rounded-full bg-black/40 text-white flex items-center justify-center hover:bg-black/60 transition cursor-pointer">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        {{-- Flecha derecha --}}
        <button onclick="moveSlider(1)"
            class="absolute right-3 top-1/2 -translate-y-1/2 z-10 h-10 w-10 rounded-full bg-black/40 text-white flex items-center justify-center hover:bg-black/60 transition cursor-pointer">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        {{-- Dots --}}
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-10 flex gap-2" id="sliderDots">
            <button onclick="goToSlide(0)" class="h-2.5 w-2.5 rounded-full bg-white transition cursor-pointer"></button>
            <button onclick="goToSlide(1)" class="h-2.5 w-2.5 rounded-full bg-white/40 transition cursor-pointer"></button>
            <button onclick="goToSlide(2)" class="h-2.5 w-2.5 rounded-full bg-white/40 transition cursor-pointer"></button>
            <button onclick="goToSlide(3)" class="h-2.5 w-2.5 rounded-full bg-white/40 transition cursor-pointer"></button>
        </div>

        {{-- Redes sociales lateral --}}
        <div class="hidden lg:flex absolute left-4 bottom-4 z-10 flex-col gap-3">
            <a href="#"
                class="h-8 w-8 rounded-full bg-black/40 flex items-center justify-center hover:bg-black/60 transition">
                <svg class="h-4 w-4 fill-current text-white" viewBox="0 0 24 24">
                    <path
                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                </svg>
            </a>
            <a href="#"
                class="h-8 w-8 rounded-full bg-black/40 flex items-center justify-center hover:bg-black/60 transition">
                <svg class="h-4 w-4 fill-current text-white" viewBox="0 0 24 24">
                    <path
                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                </svg>
            </a>
            <a href="#"
                class="h-8 w-8 rounded-full bg-black/40 flex items-center justify-center hover:bg-black/60 transition">
                <svg class="h-4 w-4 fill-current text-white" viewBox="0 0 24 24">
                    <path
                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                </svg>
            </a>
        </div>
    </section>

    <script>
        // Contadores jackpot (loop infinito, inicia desde la mitad, velocidad proporcional al máximo)
        document.querySelectorAll('.jackpot-counter').forEach(el => {
            const target = parseInt(el.dataset.target);
            const half = Math.floor(target / 2);
            const step = Math.max(1, Math.ceil(half / 250000));
            let current = half;

            el.textContent = '$' + current.toLocaleString('es-CO');

            setInterval(() => {
                current += step;
                if (current > target) current = half;
                el.textContent = '$' + current.toLocaleString('es-CO');
            }, 40);
        });

        // Slider
        let currentSlide = 0;
        const totalSlides = 4;
        const track = document.getElementById('sliderTrack');
        const dots = document.getElementById('sliderDots').children;
        let autoSlide = setInterval(() => moveSlider(1), 5000);

        function updateSlider() {
            track.style.transform = `translateX(-${currentSlide * 100}%)`;
            for (let i = 0; i < dots.length; i++) {
                dots[i].className = i === currentSlide
                    ? 'h-2.5 w-2.5 rounded-full bg-white transition cursor-pointer'
                    : 'h-2.5 w-2.5 rounded-full bg-white/40 transition cursor-pointer';
            }
        }

        function moveSlider(dir) {
            currentSlide = (currentSlide + dir + totalSlides) % totalSlides;
            updateSlider();
            clearInterval(autoSlide);
            autoSlide = setInterval(() => moveSlider(1), 5000);
        }

        function goToSlide(i) {
            currentSlide = i;
            updateSlider();
            clearInterval(autoSlide);
            autoSlide = setInterval(() => moveSlider(1), 5000);
        }
    </script>

    <section class="bg-gradient-to-r from-[#001233] to-[#001845] p-12 flex justify-center">
        <div class="min-w-0 flex flex-col text-center">
            <p class="text-xl font-bold tracking-wide leading-tight text-white">Entra al mundo de ganadores BetPlay,
                diviértete apostando con toda la oferta de</p>
            <p class="text-xl font-bold tracking-wide leading-tight text-white">apuestas que tenemos para ti.</p>
            <button class="w-[220px] h-[40px] rounded 
                                        bg-[#28a745] text-[14px] font-bold 
                                        py-1 px-0 mx-auto mt-6
                                        flex items-center justify-center 
                                        text-white 
                                        transition-colors duration-300">
                ¡Juega Ya!
            </button>
        </div>

    </section>

    {{-- Pasos: Regístrate, Recarga, Apuesta y Gana --}}
    <section class="bg-[#002361]">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3">
            {{-- Paso 1 --}}
            <div class="flex items-center justify-between px-8 py-5">
                <div>
                    <p class="text-white font-bold text-lg">1. Regístrate</p>
                    <p class="text-[#3dafdf] font-bold text-sm mt-1">Abre tu cuenta GRATIS</p>
                </div>
                <div class="rounded-full bg-[#001849] p-2">
                    <svg class="h-6 w-6 text-white shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
            {{-- Paso 2 --}}
            <div class="flex items-center justify-between px-8 py-5">
                <div>
                    <p class="text-white font-bold text-lg">2. Recarga</p>
                    <p class="text-[#3dafdf] font-bold text-sm mt-1">Disfruta de la mejor oferta de</p>
                    <p class="text-[#3dafdf] font-bold text-sm">apuestas online del mercado</p>
                </div>
                <div class="rounded-full bg-[#001849] p-2">
                    <svg class="h-6 w-6 text-white shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
            {{-- Paso 3 --}}
            <div class="flex items-center justify-between px-8 py-5">
                <div>
                    <p class="text-white font-bold text-lg">3. Apuesta y Gana</p>
                    <p class="text-[#3dafdf] font-bold text-sm mt-1">Diviértete en la casa de apuestas</p>
                    <p class="text-[#3dafdf] font-bold text-sm">más grande de Colombia</p>
                </div>
                <div class="rounded-full bg-[#001849] p-2">
                    <svg class="h-6 w-6 text-white shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#c6d8e8] px-6 lg:px-12 py-10">

    <!-- BLOQUE 1 -->
    <div class="flex flex-col lg:flex-row items-center gap-8 py-8">

        <div class="w-full lg:w-1/2">
            <img class="w-full h-auto"
                 src="{{ asset('assets/img/banners/Chicos_Sports.png') }}"
                 alt="">
        </div>

        <div class="w-full lg:w-1/2 flex flex-col items-center lg:items-start justify-center text-center lg:text-left">
            <img src="{{ asset('assets/img/banners/sports.svg') }}" alt="">

            <h4 class="mt-4 font-bold text-base lg:text-lg text-[#072965] leading-tight max-w-xl">
                Juega ahora en la casa de apuestas más grande de Colombia y siente la pasión de apostar en nuestras
                ofertas deportivas con las mejores cuotas del mercado.
            </h4>

            <button class="w-[220px] h-[40px] rounded 
                           bg-[#28a745] text-[14px] font-bold 
                           mt-6 flex items-center justify-center
                           text-white transition-colors duration-300 hover:bg-[#218838]">
                ¡Juega Ya!
            </button>
        </div>

    </div>


    <!-- BLOQUE 2 -->
    <div class="flex flex-col lg:flex-row items-center gap-8 py-8">

        <div class="w-full lg:w-1/2 flex flex-col items-center lg:items-start justify-center text-center lg:text-left order-2 lg:order-1">
            <img src="{{ asset('assets/img/banners/casino.svg') }}" alt="">

            <h4 class="mt-4 font-bold text-base lg:text-lg text-[#072965] leading-tight max-w-xl">
                Diversión y miles de posibilidades de ganar las encuentras en el Casino BetPlay con el mejor
                portafolio de juegos de azar de la categoría.
            </h4>

            <button class="w-[220px] h-[40px] rounded 
                           bg-[#28a745] text-[14px] font-bold 
                           mt-6 flex items-center justify-center
                           text-white transition-colors duration-300 hover:bg-[#218838]">
                ¡Juega Ya!
            </button>
        </div>

        <div class="w-full lg:w-1/2 order-1 lg:order-2">
            <img class="w-full h-auto"
                 src="{{ asset('assets/img/banners/Chica_Casino.png') }}"
                 alt="">
        </div>

    </div>


    <!-- BLOQUE 3 -->
    <div class="flex flex-col lg:flex-row items-center gap-8 py-8">

        <div class="w-full lg:w-1/2">
            <img class="w-full h-auto"
                 src="{{ asset('assets/img/banners/Personaje.png') }}"
                 alt="">
        </div>

        <div class="w-full lg:w-1/2 flex flex-col items-center lg:items-start justify-center text-center lg:text-left">
            <img src="{{ asset('assets/img/banners/poker.svg') }}" alt="">

            <h4 class="mt-4 font-bold text-base lg:text-lg text-[#072965] leading-tight max-w-xl">
                Juega ahora en la casa de apuestas más grande de Colombia y siente la pasión de apostar en nuestras
                ofertas deportivas con las mejores cuotas del mercado.
            </h4>

            <button class="w-[220px] h-[40px] rounded 
                           bg-[#28a745] text-[14px] font-bold 
                           mt-6 flex items-center justify-center
                           text-white transition-colors duration-300 hover:bg-[#218838]">
                ¡Juega Ya!
            </button>
        </div>

    </div>

</section>


@endsection