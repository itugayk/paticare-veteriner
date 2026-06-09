<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PatiCare Veteriner Kliniği') — PatiCare</title>
    <meta name="description" content="@yield('meta_description', 'PatiCare Veteriner Kliniği — genel muayene, aşı, cerrahi, diş, 7/24 acil, pet kuaför ve petshop. Dostça, güvenilir bakım.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Nunito:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=Quicksand:wght@500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>[x-cloak]{display:none!important}</style>

    {{-- JSON-LD: VeterinaryCare --}}
    @php
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'VeterinaryCare',
            'name' => 'PatiCare Veteriner Kliniği',
            'description' => 'Genel muayene, aşı, cerrahi, diş, 7/24 acil, pet kuaför ve petshop hizmetleri sunan dostça ve güvenilir veteriner kliniği.',
            'url' => config('app.url'),
            'telephone' => '+90 850 000 00 00',
            'image' => asset('images/og.jpg'),
            'priceRange' => '₺₺',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Bağdat Caddesi No:128',
                'addressLocality' => 'Kadıköy',
                'addressRegion' => 'İstanbul',
                'postalCode' => '34000',
                'addressCountry' => 'TR',
            ],
            'openingHoursSpecification' => [
                ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday'], 'opens' => '09:00', 'closes' => '20:00'],
                ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => ['Saturday','Sunday'], 'opens' => '10:00', 'closes' => '18:00'],
            ],
            'availableService' => array_map(fn ($n) => ['@type' => 'MedicalProcedure', 'name' => $n],
                ['Genel Muayene', 'Aşı', 'Cerrahi', 'Diş Bakımı', '7/24 Acil']),
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
</head>
<body class="min-h-screen antialiased">
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @livewireScripts
    @stack('scripts')
</body>
</html>
