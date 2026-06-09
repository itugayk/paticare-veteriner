@php
    $nav = [
        ['label' => 'Ana Sayfa', 'route' => 'home'],
        ['label' => 'Hizmetler', 'route' => 'services'],
        ['label' => 'Hekimler', 'route' => 'vets'],
        ['label' => 'Galeri', 'route' => 'gallery'],
        ['label' => 'Blog', 'route' => 'blog.index'],
        ['label' => 'İletişim', 'route' => 'contact'],
    ];
@endphp

{{-- Emergency strip --}}
<div class="bg-peach-500 text-white">
    <div class="section flex flex-wrap items-center justify-center gap-x-6 gap-y-1 py-2 text-center text-sm font-semibold">
        <span class="inline-flex items-center gap-2">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75A2.25 2.25 0 0 1 6 4.5h1.6a1.5 1.5 0 0 1 1.45 1.1l.74 2.7a1.5 1.5 0 0 1-.4 1.46l-1.1 1.1a12 12 0 0 0 5.6 5.6l1.1-1.1a1.5 1.5 0 0 1 1.46-.4l2.7.74a1.5 1.5 0 0 1 1.1 1.45V19.5a2.25 2.25 0 0 1-2.25 2.25C9.7 21.75 2.25 14.3 2.25 5.25"/></svg>
            7/24 Acil Hat: <a href="tel:+908500000000" class="underline decoration-2 underline-offset-2">0850 000 00 00</a>
        </span>
        <span class="hidden sm:inline-flex items-center gap-2 opacity-90">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 2m6-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            Hafta içi 09:00–20:00 · Hafta sonu 10:00–18:00
        </span>
    </div>
</div>

<header x-data="{ open: false, scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 10"
        class="sticky top-0 z-50 border-b border-paw-100/70 bg-cream-50/90 backdrop-blur transition"
        :class="scrolled ? 'shadow-lg shadow-paw-900/5' : ''">
    <nav class="section flex items-center justify-between py-3.5">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5">
            <span class="grid h-11 w-11 place-items-center rounded-2xl bg-paw-500 text-white shadow-md shadow-paw-500/30">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><path d="M12 13.5c2.2 0 4.5 1.7 4.5 3.9 0 1.4-1.1 2.1-2.4 2.1-.9 0-1.6-.4-2.1-.4s-1.2.4-2.1.4c-1.3 0-2.4-.7-2.4-2.1 0-2.2 2.3-3.9 4.5-3.9Zm-5-1.2c1 0 1.6 1.1 1.4 2.3-.2 1.2-1.1 2-2.1 1.8-1-.2-1.6-1.3-1.4-2.5.2-1.1 1.1-1.8 2.1-1.6Zm10 0c1-.2 1.9.5 2.1 1.6.2 1.2-.4 2.3-1.4 2.5-1 .2-1.9-.6-2.1-1.8-.2-1.2.4-2.3 1.4-2.3ZM9 6.2c1 0 1.7 1.1 1.5 2.4-.2 1.3-1.1 2.1-2.1 2-1-.2-1.7-1.3-1.5-2.6C7.1 6.8 8 6 9 6.2Zm6 0c1-.2 1.9.6 2.1 1.8.2 1.3-.5 2.4-1.5 2.6-1 .1-1.9-.7-2.1-2-.2-1.3.5-2.4 1.5-2.4Z"/></svg>
            </span>
            <span class="font-display text-xl font-extrabold leading-none text-paw-700">PatiCare<span class="block text-[0.7rem] font-semibold uppercase tracking-widest text-peach-500">Veteriner Kliniği</span></span>
        </a>

        <div class="hidden items-center gap-1 lg:flex">
            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}"
                   class="rounded-full px-4 py-2 font-display text-[0.95rem] font-semibold transition {{ request()->routeIs($item['route']) ? 'bg-paw-100 text-paw-700' : 'text-slate-600 hover:bg-paw-50 hover:text-paw-700' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>

        <div class="hidden items-center gap-2 lg:flex">
            <a href="{{ auth()->check() ? route('owner.dashboard') : route('login') }}" class="btn-ghost !px-5 !py-2.5 text-sm">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 19.5a7.5 7.5 0 0 1 15 0"/></svg>
                {{ auth()->check() ? 'Panelim' : 'Sahip Girişi' }}
            </a>
            <a href="{{ route('appointment') }}" class="btn-primary !px-5 !py-2.5 text-sm">Randevu Al</a>
        </div>

        <button @click="open = !open" class="grid h-11 w-11 place-items-center rounded-2xl bg-paw-100 text-paw-700 lg:hidden" aria-label="Menü">
            <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M6 6l12 12M18 6 6 18"/></svg>
        </button>
    </nav>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak x-transition class="border-t border-paw-100 bg-cream-50 lg:hidden">
        <div class="section flex flex-col gap-1 py-4">
            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}" class="rounded-2xl px-4 py-3 font-display font-semibold {{ request()->routeIs($item['route']) ? 'bg-paw-100 text-paw-700' : 'text-slate-600' }}">{{ $item['label'] }}</a>
            @endforeach
            <div class="mt-2 grid grid-cols-2 gap-2">
                <a href="{{ auth()->check() ? route('owner.dashboard') : route('login') }}" class="btn-ghost !py-2.5 text-sm">{{ auth()->check() ? 'Panelim' : 'Sahip Girişi' }}</a>
                <a href="{{ route('appointment') }}" class="btn-primary !py-2.5 text-sm">Randevu Al</a>
            </div>
        </div>
    </div>
</header>
