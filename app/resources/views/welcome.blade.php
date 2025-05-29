<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BarEspe VentasPro</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-[#fdfdfd] text-[#1b1b18] flex flex-col min-h-screen p-6 lg:p-10 items-center justify-start">

    {{-- NAV --}}
    <header class="w-full max-w-6xl text-sm mb-8">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="inline-block px-5 py-1.5 border border-[#ccc] hover:border-[#999] text-[#1b1b18] rounded-sm">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-block px-5 py-1.5 text-[#1b1b18] hover:underline underline-offset-4">
                        Iniciar sesión
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="inline-block px-5 py-1.5 border border-[#ccc] hover:border-[#999] text-[#1b1b18] rounded-sm">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
    </header>

    {{-- MAIN --}}
    <main class="w-full max-w-6xl flex flex-col gap-12">

        {{-- HERO --}}
        <section class="text-center flex flex-col items-center gap-6">
            <h1 class="text-5xl lg:text-7xl font-semibold leading-tight">
                Sistema de Registro de Ventas
            </h1>
            <p class="text-lg lg:text-xl text-[#666] max-w-3xl">
                Controla, analiza y proyecta tus ingresos con una plataforma adaptable a negocios de cualquier tamaño.
            </p>
        </section>

        {{-- MÓDULOS --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $modules = [
                    ['Ventas',        'Registra ventas en segundos, aplica descuentos y genera comprobantes automáticamente.'],
                    ['Inventario',    'Sincroniza existencias en tiempo real y recibe alertas de stock bajo.'],
                    ['Clientes',      'Historial de compra, saldos pendientes y segmentación avanzada para campañas.'],
                    ['Reportes',      'Dashboards de KPIs diarios, mensuales y anuales listos para exportar.'],
                ];
            @endphp

            @foreach($modules as [$title, $body])
                <article class="border border-[#e3e3e0] rounded-lg p-6 bg-white shadow-sm flex flex-col gap-3">
                    <h2 class="text-xl font-semibold">{{ $title }}</h2>
                    <p class="text-sm text-[#666]">{{ $body }}</p>
                </article>
            @endforeach
        </section>

        {{-- BENEFICIOS --}}
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @php
                $perks = [
                    ['Implementación exprés',       'Puesta en marcha en menos de 48 horas, sin interrupciones en tu operación.'],
                    ['Multi-sucursal',              'Centraliza ventas y existencias de todas tus tiendas o puntos de servicio.'],
                    ['Escalable y modular',         'Añade nuevas funcionalidades cuando tu negocio lo necesite, sin migraciones.'],
                    ['Seguridad y respaldo',        'Copia diaria automática y cifrado de base de datos de extremo a extremo.'],
                ];
            @endphp

            @foreach($perks as [$title, $body])
                <article class="border-l-4 border-[#f53003] bg-[#fff2f2] rounded-r-lg p-6">
                    <h3 class="text-lg font-medium">{{ $title }}</h3>
                    <p class="text-sm">{{ $body }}</p>
                </article>
            @endforeach
        </section>

        {{-- SOBRE NOSOTROS --}}
        <section class="flex flex-col lg:flex-row gap-8">
            <div class="flex-1">
                <h2 class="text-3xl font-semibold mb-4">Acerca de Ventax Solutions</h2>
                <p class="text-base text-[#666] leading-relaxed">
                    Somos una empresa ecuatoriana dedicada a ofrecer herramientas tecnológicas que potencien el crecimiento de pequeños y medianos negocios en Latinoamérica. Nuestro equipo combina más de 10 años de experiencia en desarrollo de software, consultoría contable y ciencia de datos.
                </p>
            </div>

            <div class="flex-1 grid grid-cols-2 gap-6">
                @php
                    $stats = [
                        ['+300',  'comercios activos'],
                        ['99,8 %', 'uptime garantizado'],
                        ['24/7',   'soporte técnico'],
                        ['3 horas', 'tiempo medio de respuesta'],
                    ];
                @endphp

                @foreach($stats as [$value, $label])
                    <div class="rounded-lg border border-[#e3e3e0] p-6 text-center">
                        <span class="block text-3xl font-semibold">{{ $value }}</span>
                        <span class="block text-sm text-[#666]">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- CTA --}}
        <section class="text-center mt-8">
            <a href="{{ route('register') }}"
               class="inline-block px-8 py-3 rounded-sm bg-black text-white hover:opacity-90 transition-opacity">
                Prueba gratis 14 días
            </a>
        </section>
    </main>
</body>
</html>
