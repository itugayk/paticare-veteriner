@props(['eyebrow' => null, 'title', 'subtitle' => null, 'align' => 'center'])

<div class="{{ $align === 'center' ? 'mx-auto max-w-2xl text-center' : 'max-w-2xl' }}">
    @if ($eyebrow)
        <span class="eyebrow">🐾 {{ $eyebrow }}</span>
    @endif
    <h2 class="mt-4 text-balance text-3xl font-extrabold text-paw-800 sm:text-4xl">{{ $title }}</h2>
    @if ($subtitle)
        <p class="mt-4 text-lg leading-relaxed text-slate-500">{{ $subtitle }}</p>
    @endif
</div>
