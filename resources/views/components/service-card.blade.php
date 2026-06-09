@props(['service'])

@php $peach = $service->color === 'peach'; @endphp

<a href="{{ route('services.show', $service) }}"
   class="group card relative flex flex-col gap-4 p-7 transition hover:-translate-y-1 hover:shadow-2xl">
    @if ($service->is_emergency)
        <span class="absolute right-5 top-5 rounded-full bg-peach-100 px-3 py-1 text-xs font-bold text-peach-700">7/24</span>
    @endif
    <span class="grid h-14 w-14 place-items-center rounded-2xl {{ $peach ? 'bg-peach-100 text-peach-600' : 'bg-paw-100 text-paw-600' }} transition group-hover:scale-110">
        <x-service-icon :name="$service->icon" class="h-7 w-7" />
    </span>
    <div>
        <h3 class="font-display text-xl font-bold text-paw-800">{{ $service->name }}</h3>
        <p class="mt-2 text-[0.95rem] leading-relaxed text-slate-500">{{ $service->excerpt }}</p>
    </div>
    <div class="mt-auto flex items-center justify-between pt-2">
        @if ($service->price_from)
            <span class="font-display text-sm font-bold {{ $peach ? 'text-peach-600' : 'text-paw-600' }}">{{ $service->price_from }}’den</span>
        @else
            <span></span>
        @endif
        <span class="inline-flex items-center gap-1 font-display text-sm font-semibold text-slate-400 transition group-hover:text-paw-600">
            Detay
            <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
        </span>
    </div>
</a>
