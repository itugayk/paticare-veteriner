@extends('layouts.app')

@section('title', 'İletişim')
@section('meta_description', 'PatiCare Veteriner Kliniği iletişim bilgileri, adres ve randevu hattı.')

@section('content')

<x-page-hero eyebrow="İletişim" title="Bize ulaşın"
    subtitle="Sorularınız, randevularınız ve acil durumlar için her zaman buradayız." />

<section class="section py-16">
    <div class="grid gap-10 lg:grid-cols-2">
        {{-- Info --}}
        <div>
            <div class="grid gap-4 sm:grid-cols-2">
                @php
                    $cards = [
                        ['📍','Adres','Bağdat Caddesi No:128<br>Kadıköy / İstanbul'],
                        ['📞','Telefon','<a href="tel:+908500000000" class="hover:text-paw-600">0850 000 00 00</a>'],
                        ['✉️','E-posta','<a href="mailto:merhaba@paticare.com" class="hover:text-paw-600">merhaba@paticare.com</a>'],
                        ['🕘','Saatler','Hafta içi 09–20<br>Hafta sonu 10–18'],
                    ];
                @endphp
                @foreach ($cards as [$emoji, $title, $body])
                    <div class="card p-6">
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-paw-100 text-2xl">{{ $emoji }}</span>
                        <p class="mt-4 font-display font-bold text-paw-800">{{ $title }}</p>
                        <p class="mt-1 text-sm leading-relaxed text-slate-500">{!! $body !!}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 overflow-hidden rounded-[var(--radius-card)] border-4 border-white shadow-xl">
                <iframe title="Harita" class="h-64 w-full" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    src="https://www.openstreetmap.org/export/embed.html?bbox=29.02%2C40.98%2C29.08%2C41.01&layer=mapnik"></iframe>
            </div>

            <div class="mt-4 flex items-center gap-3 rounded-[var(--radius-card)] bg-peach-500 p-5 text-white">
                <span class="text-3xl">🚑</span>
                <div>
                    <p class="font-display font-bold">Acil bir durum mu var?</p>
                    <p class="text-sm text-white/90">7/24 acil hattımız: <a class="font-bold underline" href="tel:+908500000000">0850 000 00 00</a></p>
                </div>
            </div>
        </div>

        {{-- Form --}}
        <div class="card p-7 sm:p-9">
            <h2 class="font-display text-2xl font-extrabold text-paw-800">Mesaj gönderin</h2>
            <p class="mt-1 text-sm text-slate-500">Formu doldurun, en kısa sürede size dönelim.</p>

            @if (session('status'))
                <div class="mt-5 rounded-2xl bg-paw-100 px-4 py-3 text-sm font-semibold text-paw-700">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('contact.store') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="label" for="name">Adınız Soyadınız</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" class="input" placeholder="Adınız" required>
                    @error('name')<p class="mt-1 text-sm text-peach-600">{{ $message }}</p>@enderror
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="label" for="email">E-posta</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" class="input" placeholder="ornek@mail.com" required>
                        @error('email')<p class="mt-1 text-sm text-peach-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label" for="phone">Telefon</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}" class="input" placeholder="05xx xxx xx xx">
                    </div>
                </div>
                <div>
                    <label class="label" for="message">Mesajınız</label>
                    <textarea id="message" name="message" rows="5" class="input" placeholder="Size nasıl yardımcı olabiliriz?" required>{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-sm text-peach-600">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn-primary w-full">Gönder</button>
            </form>
        </div>
    </div>
</section>

@endsection
