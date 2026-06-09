@props(['eyebrow' => null, 'title', 'subtitle' => null])

<section class="relative overflow-hidden bg-paw-600">
    <div class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-paw-500/40 blur-2xl"></div>
    <div class="absolute -bottom-20 -left-10 h-64 w-64 rounded-full bg-peach-400/30 blur-2xl"></div>
    <div class="section relative py-16 text-center sm:py-20">
        @if ($eyebrow)
            <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-1.5 font-display text-sm font-bold uppercase tracking-wide text-white">🐾 {{ $eyebrow }}</span>
        @endif
        <h1 class="mt-4 text-balance font-display text-4xl font-extrabold text-white sm:text-5xl">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mx-auto mt-4 max-w-2xl text-lg leading-relaxed text-paw-50/90">{{ $subtitle }}</p>
        @endif
        {{ $slot }}
    </div>
    <div class="h-6 bg-cream-50" style="border-radius: 50% 50% 0 0 / 100% 100% 0 0;"></div>
</section>
