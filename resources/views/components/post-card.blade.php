@props(['post'])

<a href="{{ route('blog.show', $post) }}" class="group card flex flex-col overflow-hidden transition hover:-translate-y-1 hover:shadow-2xl">
    <div class="aspect-[16/10] overflow-hidden bg-paw-100">
        <img src="{{ media_url($post->cover, 'https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=1200&q=70') }}"
             alt="{{ $post->title }}" loading="lazy"
             class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
    </div>
    <div class="flex flex-1 flex-col p-6">
        <div class="flex items-center gap-3 text-xs font-semibold text-slate-400">
            <span class="rounded-full bg-peach-100 px-3 py-1 text-peach-700">{{ $post->category }}</span>
            <span>{{ $post->read_minutes }} dk okuma</span>
        </div>
        <h3 class="mt-3 text-balance font-display text-lg font-bold leading-snug text-paw-800 transition group-hover:text-paw-600">{{ $post->title }}</h3>
        <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-slate-500">{{ $post->excerpt }}</p>
        <div class="mt-auto flex items-center justify-between pt-4 text-xs text-slate-400">
            <span>{{ optional($post->published_at)->translatedFormat('d M Y') }}</span>
            <span class="inline-flex items-center gap-1 font-display font-semibold text-paw-600">Oku
                <svg class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
            </span>
        </div>
    </div>
</a>
