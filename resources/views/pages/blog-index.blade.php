@extends('layouts.app')

@section('title', 'Blog — Bakım Rehberi')
@section('meta_description', 'Evcil hayvan beslenmesi, sağlığı ve bakımı hakkında PatiCare hekimlerinden faydalı yazılar.')

@section('content')

<x-page-hero eyebrow="Bakım Rehberi" title="PatiCare Blog"
    subtitle="Dostlarınızın sağlıklı ve mutlu bir yaşam sürmesi için uzman önerileri." />

<section class="section py-16">
    @if ($posts->isEmpty())
        <p class="text-center text-slate-400">Henüz yazı eklenmedi.</p>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($posts as $post)
                <x-post-card :post="$post" />
            @endforeach
        </div>
        <div class="mt-10">{{ $posts->links() }}</div>
    @endif
</section>

@endsection
