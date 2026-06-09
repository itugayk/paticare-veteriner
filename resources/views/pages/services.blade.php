@extends('layouts.app')

@section('title', 'Hizmetlerimiz')
@section('meta_description', 'PatiCare veteriner kliniği hizmetleri: genel muayene, aşı, cerrahi, diş, 7/24 acil, pet kuaför ve petshop.')

@section('content')

<x-page-hero eyebrow="Hizmetlerimiz" title="Dostlarınız için kapsamlı bakım"
    subtitle="Koruyucu hekimlikten ileri cerrahiye kadar tüm ihtiyaçlarınıza tek bir sıcak adreste yanıt veriyoruz." />

<section class="section py-16">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($services as $service)
            <x-service-card :service="$service" />
        @endforeach
    </div>
</section>

<section class="section pb-20">
    <div class="rounded-[2.5rem] bg-peach-50 px-6 py-12 text-center sm:px-12">
        <h2 class="font-display text-2xl font-extrabold text-paw-800 sm:text-3xl">Hangi hizmete ihtiyacınız olduğundan emin değil misiniz?</h2>
        <p class="mx-auto mt-3 max-w-xl text-slate-500">Bizi arayın, dostunuzun durumuna en uygun bakımı birlikte planlayalım.</p>
        <div class="mt-6 flex flex-wrap justify-center gap-3">
            <a href="{{ route('appointment') }}" class="btn-primary">Randevu Al</a>
            <a href="tel:+908500000000" class="btn-ghost">0850 000 00 00</a>
        </div>
    </div>
</section>

@endsection
