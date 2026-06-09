@props(['name' => 'paw', 'class' => 'h-7 w-7'])

@php
    $paths = [
        'stethoscope' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 3v6a4.5 4.5 0 0 0 9 0V3M6.75 3v.75M11.25 3v.75M9 18a3 3 0 0 0 6 0v-1.5a3.75 3.75 0 0 0-3.75-3.75M19.5 13.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>',
        'syringe' => '<path stroke-linecap="round" stroke-linejoin="round" d="m18 9 3-3m-3 3-2.25-2.25M18 9l-7.5 7.5m0 0L9 18l-3 .75L6.75 16l1.5-1.5m2.25 2.25L8.25 14.25M14.25 9.75 9.75 14.25M4.5 19.5l1.5-1.5"/>',
        'scalpel' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 20 14 10m0 0 5-7-1.5 8L14 10Zm-3.5 3.5a2.12 2.12 0 0 1-3-3"/>',
        'tooth' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 4C5.5 4 4 5.6 4 8c0 3 1 5 1.5 8 .3 1.8.7 4 2 4s1.3-3 2.5-3 1.2 3 2.5 3 1.7-2.2 2-4c.5-3 1.5-5 1.5-8 0-2.4-1.5-4-3.5-4-1.2 0-1.8.6-3 .6S8.7 4 7.5 4Z"/>',
        'ambulance' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V7.5A1.5 1.5 0 0 1 4.5 6h9A1.5 1.5 0 0 1 15 7.5V9h2.8c.5 0 .9.2 1.2.6l1.7 2.3c.2.3.3.6.3 1v3.6M3 16.5h1.5m0 0a2.25 2.25 0 1 0 4.5 0m-4.5 0a2.25 2.25 0 1 1 4.5 0m0 0H15m0 0a2.25 2.25 0 1 0 4.5 0m-4.5 0a2.25 2.25 0 1 1 4.5 0M9 8.25V12m0 0H6.75M9 12h2.25M9 12V9.75"/>',
        'scissors' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 5.25a2.25 2.25 0 1 1 0 4.5 2.25 2.25 0 0 1 0-4.5Zm0 9a2.25 2.25 0 1 1 0 4.5 2.25 2.25 0 0 1 0-4.5Zm1.8-5.4L20.25 18M9.3 15.15 20.25 6"/>',
        'bag' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12A1.125 1.125 0 0 1 19.748 21H4.252a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 6.75h12.974c.576 0 1.059.435 1.119 1.007Z"/>',
        'paw' => '<path d="M12 13.5c2.2 0 4.5 1.7 4.5 3.9 0 1.4-1.1 2.1-2.4 2.1-.9 0-1.6-.4-2.1-.4s-1.2.4-2.1.4c-1.3 0-2.4-.7-2.4-2.1 0-2.2 2.3-3.9 4.5-3.9Zm-5-1.2c1 0 1.6 1.1 1.4 2.3-.2 1.2-1.1 2-2.1 1.8-1-.2-1.6-1.3-1.4-2.5.2-1.1 1.1-1.8 2.1-1.6Zm10 0c1-.2 1.9.5 2.1 1.6.2 1.2-.4 2.3-1.4 2.5-1 .2-1.9-.6-2.1-1.8-.2-1.2.4-2.3 1.4-2.3ZM9 6.2c1 0 1.7 1.1 1.5 2.4-.2 1.3-1.1 2.1-2.1 2-1-.2-1.7-1.3-1.5-2.6C7.1 6.8 8 6 9 6.2Zm6 0c1-.2 1.9.6 2.1 1.8.2 1.3-.5 2.4-1.5 2.6-1 .1-1.9-.7-2.1-2-.2-1.3.5-2.4 1.5-2.4Z" fill="currentColor" stroke="none"/>',
    ];
    $isFill = $name === 'paw';
@endphp

<svg {{ $attributes->merge(['class' => $class]) }} viewBox="0 0 24 24" fill="{{ $isFill ? 'currentColor' : 'none' }}" stroke="{{ $isFill ? 'none' : 'currentColor' }}" stroke-width="1.7">
    {!! $paths[$name] ?? $paths['paw'] !!}
</svg>
