@extends('layouts.app')

@section('title', 'Galeri')
@section('meta_description', 'PatiCare veteriner kliniğinden mutlu pati dostları ve klinik kareleri.')

@section('content')

<x-page-hero eyebrow="Galeri" title="Mutlu pati kareleri"
    subtitle="Kliniğimizden, ekibimizden ve mutlu dostlarımızdan anlar." />

<section class="section py-16"
         x-data="{ open: false, src: '', title: '' }"
         @keydown.escape.window="open = false">
    <div class="columns-2 gap-4 sm:columns-3 lg:columns-4 [&>*]:mb-4">
        @foreach ($images as $img)
            <button type="button"
                    @click="open = true; src = '{{ media_url($img->image) }}'; title = @js($img->title)"
                    class="group block w-full overflow-hidden rounded-3xl">
                <img src="{{ media_url($img->image) }}" alt="{{ $img->title }}" loading="lazy"
                     class="w-full object-cover transition duration-500 group-hover:scale-105">
            </button>
        @endforeach
    </div>

    {{-- Lightbox --}}
    <div x-show="open" x-cloak x-transition.opacity
         class="fixed inset-0 z-[60] grid place-items-center bg-paw-900/80 p-4 backdrop-blur"
         @click="open = false">
        <figure class="max-h-[88vh] max-w-3xl overflow-hidden rounded-3xl bg-white shadow-2xl" @click.stop>
            <img :src="src" :alt="title" class="max-h-[78vh] w-full object-contain">
            <figcaption class="p-4 text-center font-display font-semibold text-paw-800" x-text="title"></figcaption>
        </figure>
        <button @click="open = false" class="absolute right-5 top-5 grid h-11 w-11 place-items-center rounded-full bg-white/90 text-paw-800" aria-label="Kapat">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M6 6l12 12M18 6 6 18"/></svg>
        </button>
    </div>
</section>

@endsection
