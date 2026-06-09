@props(['testimonial'])

@php
    $emoji = match ($testimonial->pet_species) {
        'kedi' => '🐱', 'kopek' => '🐶', 'kus' => '🐦', 'kemirgen' => '🐹', default => '🐾',
    };
@endphp

<figure class="card flex h-full flex-col gap-4 p-7">
    <div class="flex gap-1 text-peach-400">
        @for ($i = 1; $i <= 5; $i++)
            <svg class="h-5 w-5 {{ $i <= $testimonial->rating ? 'text-peach-400' : 'text-paw-100' }}" viewBox="0 0 24 24" fill="currentColor"><path d="M11.48 3.5a.56.56 0 0 1 1.04 0l2.13 4.32 4.77.7a.56.56 0 0 1 .31.95l-3.45 3.36.81 4.75a.56.56 0 0 1-.81.59L12 16.3l-4.27 2.24a.56.56 0 0 1-.81-.59l.82-4.75-3.46-3.36a.56.56 0 0 1 .31-.95l4.77-.7Z"/></svg>
        @endfor
    </div>
    <blockquote class="flex-1 text-[1.02rem] leading-relaxed text-slate-600">“{{ $testimonial->body }}”</blockquote>
    <figcaption class="flex items-center gap-3 border-t border-paw-50 pt-4">
        <span class="grid h-11 w-11 place-items-center rounded-full bg-paw-100 text-xl">{{ $emoji }}</span>
        <div>
            <p class="font-display font-bold text-paw-800">{{ $testimonial->author }}</p>
            <p class="text-sm text-slate-400">{{ $testimonial->pet_name }} sahibi</p>
        </div>
    </figcaption>
</figure>
