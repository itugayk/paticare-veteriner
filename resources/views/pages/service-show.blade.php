@extends('layouts.app')

@section('title', $service->name)
@section('meta_description', $service->excerpt)

@section('content')

@php $peach = $service->color === 'peach'; @endphp

<x-page-hero :eyebrow="'Hizmet'" :title="$service->name" :subtitle="$service->excerpt" />

<section class="section py-16">
    <div class="grid gap-10 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <span class="grid h-16 w-16 place-items-center rounded-3xl {{ $peach ? 'bg-peach-100 text-peach-600' : 'bg-paw-100 text-paw-600' }}">
                <x-service-icon :name="$service->icon" class="h-8 w-8" />
            </span>
            <div class="prose-paw mt-6 space-y-4 text-lg leading-relaxed text-slate-600">
                <p>{{ $service->description }}</p>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <div class="card flex items-center gap-4 p-5">
                    <span class="grid h-12 w-12 place-items-center rounded-2xl bg-paw-100 text-2xl">⏱️</span>
                    <div><p class="text-sm text-slate-400">Ortalama süre</p><p class="font-display font-bold text-paw-800">~{{ $service->duration_minutes }} dakika</p></div>
                </div>
                @if ($service->price_from)
                    <div class="card flex items-center gap-4 p-5">
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-peach-100 text-2xl">💛</span>
                        <div><p class="text-sm text-slate-400">Başlangıç ücreti</p><p class="font-display font-bold text-paw-800">{{ $service->price_from }}</p></div>
                    </div>
                @endif
            </div>
        </div>

        <aside class="lg:sticky lg:top-28 lg:self-start">
            <div class="card p-7 text-center">
                <p class="text-3xl">🐾</p>
                <h3 class="mt-2 font-display text-xl font-bold text-paw-800">Bu hizmet için randevu alın</h3>
                <p class="mt-2 text-sm text-slate-500">Birkaç adımda online randevunuzu oluşturun.</p>
                <a href="{{ route('appointment') }}" class="btn-primary mt-5 w-full">Randevu Al</a>
                <a href="tel:+908500000000" class="btn-ghost mt-3 w-full">Hemen Ara</a>
            </div>
        </aside>
    </div>

    <div class="mt-16">
        <h2 class="font-display text-2xl font-extrabold text-paw-800">Diğer hizmetler</h2>
        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($others as $other)
                <x-service-card :service="$other" />
            @endforeach
        </div>
    </div>
</section>

@endsection
