@extends('layouts.app')

@section('title', 'Panelim')

@section('content')
<section class="bg-paw-600">
    <div class="section flex flex-col gap-4 py-10 sm:flex-row sm:items-center sm:justify-between">
        <div class="text-white">
            <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-bold uppercase tracking-wide">🐾 Pati Sahibi Paneli</span>
            <h1 class="mt-3 font-display text-3xl font-extrabold">Merhaba, {{ $user->name }}!</h1>
            <p class="mt-1 text-paw-50/90">Dostlarınızın sağlık durumunu buradan takip edin.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('appointment') }}" class="btn-peach !py-2.5 text-sm">Yeni Randevu</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn-ghost !border-white/40 !bg-white/10 !py-2.5 text-sm !text-white hover:!bg-white/20">Çıkış</button>
            </form>
        </div>
    </div>
</section>

<section class="section -mt-6 pb-20">
    @if (session('status'))
        <div class="mb-6 rounded-2xl bg-paw-100 px-5 py-3 font-semibold text-paw-700">{{ session('status') }}</div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Pets --}}
        <div class="lg:col-span-2">
            <div class="card p-6 sm:p-8">
                <div class="flex items-center justify-between">
                    <h2 class="font-display text-xl font-extrabold text-paw-800">Dostlarım</h2>
                    <a href="{{ route('owner.pets.create') }}" class="inline-flex items-center gap-1.5 rounded-full bg-paw-100 px-4 py-2 text-sm font-bold text-paw-700 transition hover:bg-paw-200">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        Yeni Dost Ekle
                    </a>
                </div>

                @if ($pets->isEmpty())
                    <div class="mt-6 rounded-2xl border-2 border-dashed border-paw-100 p-10 text-center">
                        <p class="text-4xl">🐾</p>
                        <p class="mt-3 font-display font-bold text-paw-800">Henüz dost eklemediniz</p>
                        <p class="mt-1 text-sm text-slate-500">İlk evcil hayvanınızı ekleyerek başlayın.</p>
                        <a href="{{ route('owner.pets.create') }}" class="btn-primary mt-5">Dost Ekle</a>
                    </div>
                @else
                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        @foreach ($pets as $pet)
                            @php
                                $due = $pet->vaccinations->filter(fn ($v) => in_array($v->reminder_status, ['overdue','due_soon']))->count();
                            @endphp
                            <a href="{{ route('owner.pets.show', $pet) }}" class="group flex gap-4 rounded-3xl border-2 border-paw-100 p-4 transition hover:border-paw-300 hover:bg-cream-100">
                                <span class="h-20 w-20 shrink-0 overflow-hidden rounded-2xl bg-paw-100">
                                    @if ($pet->photo)
                                        <img src="{{ media_url($pet->photo) }}" alt="{{ $pet->name }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="grid h-full w-full place-items-center text-3xl">{{ $pet->emoji }}</span>
                                    @endif
                                </span>
                                <div class="min-w-0">
                                    <p class="font-display text-lg font-bold text-paw-800">{{ $pet->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $pet->species_label }}{{ $pet->breed ? ' · ' . $pet->breed : '' }}</p>
                                    @if ($pet->age)<p class="text-xs text-slate-400">{{ $pet->age }}</p>@endif
                                    @if ($due)
                                        <span class="mt-2 inline-flex items-center gap-1 rounded-full bg-peach-100 px-2.5 py-0.5 text-xs font-bold text-peach-700">💉 {{ $due }} aşı hatırlatması</span>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Appointments --}}
            <div class="card mt-6 p-6 sm:p-8">
                <h2 class="font-display text-xl font-extrabold text-paw-800">Randevularım</h2>
                @if ($appointments->isEmpty())
                    <p class="mt-4 text-sm text-slate-500">Henüz randevunuz yok. <a href="{{ route('appointment') }}" class="font-semibold text-paw-600 hover:underline">Hemen oluşturun.</a></p>
                @else
                    <div class="mt-5 space-y-3">
                        @foreach ($appointments as $appt)
                            @php
                                $badge = match ($appt->status) {
                                    'confirmed' => 'bg-paw-100 text-paw-700',
                                    'completed' => 'bg-slate-100 text-slate-500',
                                    'cancelled' => 'bg-peach-100 text-peach-700',
                                    default => 'bg-peach-100 text-peach-700',
                                };
                            @endphp
                            <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-paw-50 bg-cream-50 px-5 py-4">
                                <div>
                                    <p class="font-display font-bold text-paw-800">{{ $appt->service?->name ?? 'Randevu' }} <span class="text-slate-400">·</span> {{ $appt->pet_name }}</p>
                                    <p class="text-sm text-slate-500">{{ $appt->date->translatedFormat('d F Y') }} · {{ $appt->time_slot }} {{ $appt->vet ? '· ' . $appt->vet->name : '' }}</p>
                                </div>
                                <span class="rounded-full px-3 py-1 text-xs font-bold {{ $badge }}">{{ $appt->status_label }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Vaccination reminders --}}
        <div>
            <div class="card p-6 sm:p-8">
                <h2 class="font-display text-xl font-extrabold text-paw-800">💉 Aşı Hatırlatmaları</h2>
                @if ($upcomingVaccinations->isEmpty())
                    <div class="mt-5 rounded-2xl bg-paw-50 p-5 text-center text-sm text-paw-700">
                        🎉 Harika! Yaklaşan veya geçmiş bir aşı bulunmuyor.
                    </div>
                @else
                    <div class="mt-5 space-y-3">
                        @foreach ($upcomingVaccinations as $v)
                            @php $overdue = $v->reminder_status === 'overdue'; @endphp
                            <div class="rounded-2xl border-l-4 p-4 {{ $overdue ? 'border-peach-500 bg-peach-50' : 'border-paw-400 bg-paw-50' }}">
                                <div class="flex items-center justify-between">
                                    <p class="font-display font-bold text-paw-800">{{ $v->name }}</p>
                                    <span class="text-xs font-bold {{ $overdue ? 'text-peach-700' : 'text-paw-700' }}">{{ $overdue ? 'GECİKTİ' : 'YAKLAŞIYOR' }}</span>
                                </div>
                                <p class="mt-1 text-sm text-slate-500">{{ $v->pet->name }} · {{ $v->next_due_at->translatedFormat('d F Y') }}</p>
                                <p class="text-xs text-slate-400">{{ $v->next_due_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('appointment') }}" class="btn-primary mt-5 w-full !py-2.5 text-sm">Aşı Randevusu Al</a>
                @endif
            </div>

            <div class="card mt-6 bg-paw-600 p-6 text-white">
                <p class="text-3xl">🩺</p>
                <p class="mt-2 font-display font-bold">Acil bir durum mu var?</p>
                <p class="mt-1 text-sm text-paw-50/90">7/24 acil hattımız her zaman açık.</p>
                <a href="tel:+908500000000" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-full bg-white py-2.5 font-display font-bold text-paw-700">0850 000 00 00</a>
            </div>
        </div>
    </div>
</section>
@endsection
