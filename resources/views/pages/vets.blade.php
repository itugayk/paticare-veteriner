@extends('layouts.app')

@section('title', 'Veteriner Hekimler')
@section('meta_description', 'PatiCare’in deneyimli ve hayvansever veteriner hekim kadrosuyla tanışın.')

@section('content')

<x-page-hero eyebrow="Ekibimiz" title="Veteriner hekimlerimiz"
    subtitle="Alanında uzman, sabırlı ve güler yüzlü kadromuzla dostlarınız emin ellerde." />

<section class="section py-16">
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($vets as $vet)
            <x-vet-card :vet="$vet" />
        @endforeach
    </div>
</section>

@endsection
