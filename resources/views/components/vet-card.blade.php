@props(['vet'])

<div class="group card overflow-hidden">
    <div class="relative aspect-[4/5] overflow-hidden bg-paw-100">
        <img src="{{ media_url($vet->photo, 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=600&q=70') }}"
             alt="{{ $vet->name }}" loading="lazy"
             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-paw-900/80 to-transparent p-5">
            <p class="font-display text-lg font-bold text-white">{{ $vet->name }}</p>
            <p class="text-sm text-paw-100">{{ $vet->title }}</p>
        </div>
    </div>
    <div class="p-5">
        <span class="eyebrow !bg-peach-100 !text-peach-700">{{ $vet->specialty }}</span>
        <p class="mt-3 text-sm leading-relaxed text-slate-500">{{ $vet->bio }}</p>
        <div class="mt-4 flex flex-wrap gap-2">
            @foreach (($vet->focus_areas ?? []) as $area)
                <span class="rounded-full bg-paw-50 px-3 py-1 text-xs font-semibold text-paw-700">{{ $area }}</span>
            @endforeach
        </div>
        <p class="mt-4 inline-flex items-center gap-2 font-display text-sm font-bold text-paw-600">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.5a.56.56 0 0 1 1.04 0l2.13 4.32 4.77.7a.56.56 0 0 1 .31.95l-3.45 3.36.81 4.75a.56.56 0 0 1-.81.59L12 16.3l-4.27 2.24a.56.56 0 0 1-.81-.59l.82-4.75-3.46-3.36a.56.56 0 0 1 .31-.95l4.77-.7Z"/></svg>
            {{ $vet->experience_years }}+ yıl deneyim
        </p>
    </div>
</div>
