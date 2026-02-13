@extends('layout')

@section('content')

    {{-- Hero banner principal --}}
    <section class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-indigo-700 to-purple-700 text-white">
        <div class="px-8 py-16 sm:py-20 lg:py-24 relative z-10">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold max-w-lg">
                Las mejores apuestas en un solo lugar
            </h1>
            <p class="mt-4 text-lg text-indigo-100 max-w-md">
                Regístrate hoy y recibe un bono de bienvenida. Vive la emoción en cada jugada.
            </p>
            <a
                href="#"
                class="mt-6 inline-block rounded-lg bg-white px-6 py-3 text-sm font-semibold text-indigo-700 hover:bg-indigo-50 transition"
            >
                Registrarme ahora
            </a>
        </div>
        {{-- Patrón decorativo --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -right-10 -top-10 h-72 w-72 rounded-full bg-white"></div>
            <div class="absolute -left-16 -bottom-16 h-96 w-96 rounded-full bg-white"></div>
        </div>
    </section>

    {{-- Deportes destacados --}}
    <section class="mt-10">
        <h2 class="text-xl font-bold text-gray-800 mb-5">Deportes destacados</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $deportes = [
                    ['nombre' => 'Fútbol',     'icono' => '⚽'],
                    ['nombre' => 'Baloncesto', 'icono' => '🏀'],
                    ['nombre' => 'Tenis',      'icono' => '🎾'],
                    ['nombre' => 'Béisbol',    'icono' => '⚾'],
                    ['nombre' => 'MMA',        'icono' => '🥊'],
                    ['nombre' => 'eSports',    'icono' => '🎮'],
                ];
            @endphp

            @foreach ($deportes as $deporte)
                <a href="#" class="flex flex-col items-center gap-2 rounded-xl bg-white p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition">
                    <span class="text-4xl">{{ $deporte['icono'] }}</span>
                    <span class="text-sm font-medium text-gray-700">{{ $deporte['nombre'] }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Banners promocionales --}}
    <section class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-8 text-white">
            <span class="text-xs font-semibold uppercase tracking-wider bg-white/20 rounded-full px-3 py-1">Promo</span>
            <h3 class="mt-4 text-2xl font-bold">Bono de bienvenida 100%</h3>
            <p class="mt-2 text-emerald-100 text-sm">Duplicamos tu primer depósito hasta $200.000. Aplican términos y condiciones.</p>
            <a href="#" class="mt-5 inline-block rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-emerald-700 hover:bg-emerald-50 transition">
                Obtener bono
            </a>
        </div>
        <div class="rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 p-8 text-white">
            <span class="text-xs font-semibold uppercase tracking-wider bg-white/20 rounded-full px-3 py-1">En vivo</span>
            <h3 class="mt-4 text-2xl font-bold">Apuestas en vivo</h3>
            <p class="mt-2 text-amber-100 text-sm">Apuesta mientras transcurre el partido. Cuotas actualizadas en tiempo real.</p>
            <a href="#" class="mt-5 inline-block rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-amber-700 hover:bg-amber-50 transition">
                Ver en vivo
            </a>
        </div>
    </section>

    {{-- Eventos populares --}}
    <section class="mt-10">
        <h2 class="text-xl font-bold text-gray-800 mb-5">Eventos populares</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @php
                $eventos = [
                    ['liga' => 'Champions League', 'local' => 'Real Madrid', 'visitante' => 'Man City', 'cuota_local' => '2.10', 'cuota_empate' => '3.40', 'cuota_visitante' => '3.15'],
                    ['liga' => 'La Liga', 'local' => 'Barcelona', 'visitante' => 'Atlético', 'cuota_local' => '1.75', 'cuota_empate' => '3.80', 'cuota_visitante' => '4.20'],
                    ['liga' => 'Premier League', 'local' => 'Liverpool', 'visitante' => 'Arsenal', 'cuota_local' => '2.30', 'cuota_empate' => '3.25', 'cuota_visitante' => '2.90'],
                    ['liga' => 'Serie A', 'local' => 'Inter', 'visitante' => 'Juventus', 'cuota_local' => '1.90', 'cuota_empate' => '3.50', 'cuota_visitante' => '3.60'],
                    ['liga' => 'Bundesliga', 'local' => 'Bayern', 'visitante' => 'Dortmund', 'cuota_local' => '1.55', 'cuota_empate' => '4.00', 'cuota_visitante' => '5.00'],
                    ['liga' => 'NBA', 'local' => 'Lakers', 'visitante' => 'Celtics', 'cuota_local' => '1.85', 'cuota_empate' => '-', 'cuota_visitante' => '1.95'],
                ];
            @endphp

            @foreach ($eventos as $evento)
                <div class="rounded-xl bg-white p-5 shadow-sm hover:shadow-md transition">
                    <span class="text-xs font-medium text-indigo-600 uppercase tracking-wider">{{ $evento['liga'] }}</span>
                    <div class="mt-3 flex items-center justify-between text-sm font-semibold text-gray-800">
                        <span>{{ $evento['local'] }}</span>
                        <span class="text-gray-400">vs</span>
                        <span>{{ $evento['visitante'] }}</span>
                    </div>
                    <div class="mt-4 grid grid-cols-3 gap-2">
                        <button class="rounded-lg bg-gray-100 py-2 text-center text-sm font-medium text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition cursor-pointer">
                            {{ $evento['cuota_local'] }}
                        </button>
                        @if ($evento['cuota_empate'] !== '-')
                            <button class="rounded-lg bg-gray-100 py-2 text-center text-sm font-medium text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition cursor-pointer">
                                {{ $evento['cuota_empate'] }}
                            </button>
                        @else
                            <div></div>
                        @endif
                        <button class="rounded-lg bg-gray-100 py-2 text-center text-sm font-medium text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition cursor-pointer">
                            {{ $evento['cuota_visitante'] }}
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection
