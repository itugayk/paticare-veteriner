@extends('layouts.app')

@section('title', $post->title)
@section('meta_description', $post->excerpt)

@section('content')

<article>
    <div class="relative overflow-hidden bg-paw-600">
        <div class="section relative py-14 text-center">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-paw-50/80 transition hover:text-white">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
                Tüm yazılar
            </a>
            <div class="mt-4 flex items-center justify-center gap-3 text-xs font-semibold text-paw-50/80">
                <span class="rounded-full bg-white/15 px-3 py-1 text-white">{{ $post->category }}</span>
                <span>{{ $post->read_minutes }} dk okuma</span>
                <span>·</span>
                <span>{{ optional($post->published_at)->translatedFormat('d F Y') }}</span>
            </div>
            <h1 class="mx-auto mt-4 max-w-3xl text-balance font-display text-3xl font-extrabold text-white sm:text-4xl">{{ $post->title }}</h1>
            <p class="mt-3 text-sm text-paw-50/80">✍️ {{ $post->author }}</p>
        </div>
    </div>

    <div class="section -mt-8 pb-16">
        <div class="mx-auto max-w-3xl overflow-hidden rounded-[2rem] border-8 border-white bg-white shadow-2xl shadow-paw-900/10">
            <img src="{{ media_url($post->cover) }}" alt="{{ $post->title }}" class="aspect-[16/9] w-full object-cover">
        </div>

        <div class="prose-paw mx-auto mt-10 max-w-3xl text-lg leading-relaxed text-slate-600
                    [&_h2]:mt-8 [&_h2]:font-display [&_h2]:text-2xl [&_h2]:font-bold [&_h2]:text-paw-800
                    [&_p]:mt-4 [&_ul]:mt-4 [&_ul]:list-disc [&_ul]:space-y-2 [&_ul]:pl-6 [&_li]:marker:text-paw-400">
            {!! $post->body !!}
        </div>

        @if ($related->isNotEmpty())
            <div class="mx-auto mt-16 max-w-5xl">
                <h2 class="font-display text-2xl font-extrabold text-paw-800">İlgili yazılar</h2>
                <div class="mt-6 grid gap-6 sm:grid-cols-2">
                    @foreach ($related as $rel)
                        <x-post-card :post="$rel" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</article>

@endsection
