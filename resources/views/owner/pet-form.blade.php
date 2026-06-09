@extends('layouts.app')

@section('title', $pet->exists ? $pet->name . ' — Düzenle' : 'Yeni Dost Ekle')

@section('content')
<x-page-hero :eyebrow="'Pati Sahibi Paneli'" :title="$pet->exists ? $pet->name . ' profilini düzenle' : 'Yeni bir dost ekle'"
    subtitle="Dostunuzun bilgilerini girin; aşı ve randevu takibini sizin için kolaylaştıralım." />

<section class="section py-12">
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-400 transition hover:text-paw-600">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
            Panele dön
        </a>

        <form method="POST"
              action="{{ $pet->exists ? route('owner.pets.update', $pet) : route('owner.pets.store') }}"
              class="card mt-4 space-y-5 p-7 sm:p-9">
            @csrf
            @if ($pet->exists) @method('PUT') @endif

            <div>
                <label class="label" for="name">Dostunuzun adı *</label>
                <input id="name" name="name" type="text" value="{{ old('name', $pet->name) }}" class="input" placeholder="Örn. Boncuk" required>
                @error('name')<p class="mt-1 text-sm text-peach-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="label" for="species">Tür *</label>
                    <select id="species" name="species" class="input" required>
                        @foreach (\App\Models\Pet::SPECIES as $key => $label)
                            <option value="{{ $key }}" @selected(old('species', $pet->species) === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="label" for="breed">Irk</label>
                    <input id="breed" name="breed" type="text" value="{{ old('breed', $pet->breed) }}" class="input" placeholder="Örn. British Shorthair">
                </div>
                <div>
                    <label class="label" for="gender">Cinsiyet</label>
                    <select id="gender" name="gender" class="input">
                        <option value="">Belirtmek istemiyorum</option>
                        <option value="erkek" @selected(old('gender', $pet->gender) === 'erkek')>Erkek ♂</option>
                        <option value="disi" @selected(old('gender', $pet->gender) === 'disi')>Dişi ♀</option>
                    </select>
                </div>
                <div>
                    <label class="label" for="birth_date">Doğum tarihi</label>
                    <input id="birth_date" name="birth_date" type="date" max="{{ now()->toDateString() }}" value="{{ old('birth_date', optional($pet->birth_date)->toDateString()) }}" class="input">
                    @error('birth_date')<p class="mt-1 text-sm text-peach-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label" for="weight_kg">Ağırlık (kg)</label>
                    <input id="weight_kg" name="weight_kg" type="number" step="0.1" min="0" value="{{ old('weight_kg', $pet->weight_kg) }}" class="input" placeholder="Örn. 4.2">
                </div>
                <div>
                    <label class="label" for="color">Renk</label>
                    <input id="color" name="color" type="text" value="{{ old('color', $pet->color) }}" class="input" placeholder="Örn. Gri">
                </div>
            </div>

            <label class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                <input type="hidden" name="is_neutered" value="0">
                <input type="checkbox" name="is_neutered" value="1" @checked(old('is_neutered', $pet->is_neutered)) class="h-4 w-4 rounded border-paw-200 text-paw-500 focus:ring-paw-300">
                Kısırlaştırıldı
            </label>

            <div>
                <label class="label" for="notes">Notlar</label>
                <textarea id="notes" name="notes" rows="3" class="input" placeholder="Alerjiler, özel durumlar, mama tercihi...">{{ old('notes', $pet->notes) }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('owner.dashboard') }}" class="btn-ghost">Vazgeç</a>
                <button type="submit" class="btn-primary">{{ $pet->exists ? 'Güncelle' : 'Dostu Ekle' }} 🐾</button>
            </div>
        </form>
    </div>
</section>
@endsection
