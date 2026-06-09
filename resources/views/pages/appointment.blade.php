@extends('layouts.app')

@section('title', 'Online Randevu')
@section('meta_description', 'PatiCare’den birkaç adımda online randevu alın: hizmet, hekim, tarih ve saat seçin.')

@section('content')

<x-page-hero eyebrow="Online Randevu" title="Birkaç adımda randevunuzu alın"
    subtitle="Hizmeti, hekimi ve uygun saati seçin; gerisini bize bırakın. 🐾" />

<section class="section py-16">
    @livewire('appointment-booking')
</section>

@endsection
