@extends('layouts.app')

@section('title', $pet->name)

@section('content')
<section class="bg-paw-600">
    <div class="section py-10">
        <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-paw-50/80 transition hover:text-white">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            Panele dön
        </a>
        <div class="mt-4 flex flex-col gap-5 sm:flex-row sm:items-center">
            <span class="h-24 w-24 overflow-hidden rounded-3xl border-4 border-white/30 bg-paw-500">
                @if ($pet->photo)
                    <img src="{{ media_url($pet->photo) }}" alt="{{ $pet->name }}" class="h-full w-full object-cover">
                @else
                    <span class="grid h-full w-full place-items-center text-4xl">{{ $pet->emoji }}</span>
                @endif
            </span>
            <div class="text-white">
                <h1 class="font-display text-3xl font-extrabold">{{ $pet->name }} {{ $pet->emoji }}</h1>
                <p class="mt-1 text-paw-50/90">{{ $pet->species_label }}{{ $pet->breed ? ' · ' . $pet->breed : '' }}{{ $pet->age ? ' · ' . $pet->age : '' }}</p>
            </div>
            <a href="{{ route('owner.pets.edit', $pet) }}" class="btn-ghost !border-white/40 !bg-white/10 !py-2.5 text-sm !text-white hover:!bg-white/20 sm:ml-auto">Düzenle</a>
        </div>
    </div>
</section>

<section class="section -mt-6 pb-20">
    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Profile facts --}}
        <div class="card p-6 sm:p-8">
            <h2 class="font-display text-lg font-extrabold text-paw-800">Profil Bilgileri</h2>
            <dl class="mt-4 space-y-3 text-sm">
                @php
                    $facts = [
                        ['Cinsiyet', $pet->gender === 'erkek' ? 'Erkek ♂' : ($pet->gender === 'disi' ? 'Dişi ♀' : '—')],
                        ['Doğum tarihi', optional($pet->birth_date)->translatedFormat('d F Y') ?? '—'],
                        ['Ağırlık', $pet->weight_kg ? $pet->weight_kg . ' kg' : '—'],
                        ['Renk', $pet->color ?? '—'],
                        ['Kısırlaştırma', $pet->is_neutered ? 'Evet' : 'Hayır'],
                        ['Mikroçip', $pet->microchip_no ?? '—'],
                    ];
                @endphp
                @foreach ($facts as [$k, $v])
                    <div class="flex justify-between gap-4 border-b border-paw-50 pb-2"><dt class="text-slate-400">{{ $k }}</dt><dd class="font-semibold text-paw-800">{{ $v }}</dd></div>
                @endforeach
            </dl>
            @if ($pet->notes)
                <div class="mt-4 rounded-2xl bg-cream-100 p-4 text-sm text-slate-600"><span class="font-semibold text-paw-700">Not:</span> {{ $pet->notes }}</div>
            @endif
        </div>

        {{-- Vaccinations --}}
        <div class="card p-6 sm:p-8 lg:col-span-2">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-lg font-extrabold text-paw-800">💉 Aşı Takvimi & Geçmişi</h2>
                <a href="{{ route('appointment') }}" class="text-sm font-bold text-paw-600 hover:underline">Aşı randevusu →</a>
            </div>

            @if ($pet->vaccinations->isEmpty())
                <p class="mt-4 text-sm text-slate-500">Henüz aşı kaydı bulunmuyor.</p>
            @else
                <div class="mt-5 space-y-3">
                    @foreach ($pet->vaccinations as $v)
                        @php
                            $map = [
                                'overdue' => ['Gecikti', 'bg-peach-100 text-peach-700', 'border-peach-400'],
                                'due_soon' => ['Yaklaşıyor', 'bg-amber-100 text-amber-700', 'border-amber-400'],
                                'ok' => ['Güncel', 'bg-paw-100 text-paw-700', 'border-paw-300'],
                                'none' => ['—', 'bg-slate-100 text-slate-500', 'border-slate-200'],
                            ];
                            [$label, $cls, $border] = $map[$v->reminder_status];
                        @endphp
                        <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border-l-4 {{ $border }} bg-cream-50 px-5 py-4">
                            <div>
                                <p class="font-display font-bold text-paw-800">{{ $v->name }}</p>
                                <p class="text-sm text-slate-500">
                                    Yapıldı: {{ optional($v->administered_at)->translatedFormat('d M Y') ?? '—' }}
                                    @if ($v->next_due_at) · Sonraki: {{ $v->next_due_at->translatedFormat('d M Y') }} @endif
                                </p>
                                @if ($v->vet)<p class="text-xs text-slate-400">{{ $v->vet->name }}</p>@endif
                            </div>
                            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $cls }}">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Appointment history --}}
            <h3 class="mt-8 font-display text-lg font-extrabold text-paw-800">📅 Randevu Geçmişi</h3>
            @if ($pet->appointments->isEmpty())
                <p class="mt-3 text-sm text-slate-500">Bu dost için randevu kaydı yok.</p>
            @else
                <div class="mt-4 space-y-2">
                    @foreach ($pet->appointments as $appt)
                        <div class="flex flex-wrap items-center justify-between gap-2 rounded-2xl bg-cream-50 px-5 py-3 text-sm">
                            <span class="font-semibold text-paw-800">{{ $appt->service?->name ?? 'Randevu' }}</span>
                            <span class="text-slate-500">{{ $appt->date->translatedFormat('d M Y') }} · {{ $appt->time_slot }}</span>
                            <span class="text-xs font-bold text-paw-600">{{ $appt->status_label }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
