@extends('layouts.app')

@section('title', 'Sahip Girişi')

@section('content')
<section class="section py-16">
    <div class="mx-auto grid max-w-5xl overflow-hidden rounded-[2.5rem] bg-white shadow-2xl shadow-paw-900/10 lg:grid-cols-2">
        {{-- Brand side --}}
        <div class="relative hidden bg-paw-600 p-10 text-white lg:flex lg:flex-col lg:justify-between">
            <div class="absolute -right-10 -top-10 h-48 w-48 rounded-full bg-paw-500/40 blur-2xl"></div>
            <div class="relative">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-white/15 text-2xl">🐾</span>
                <h2 class="mt-6 font-display text-3xl font-extrabold leading-tight">Tekrar hoş geldiniz!</h2>
                <p class="mt-3 text-paw-50/90">Dostlarınızın profillerine, aşı takvimine ve randevu geçmişine buradan ulaşın.</p>
            </div>
            <ul class="relative space-y-3 text-sm text-paw-50/90">
                <li class="flex items-center gap-2">✅ Evcil hayvan profilleri</li>
                <li class="flex items-center gap-2">💉 Aşı hatırlatmaları</li>
                <li class="flex items-center gap-2">📅 Randevu takibi</li>
            </ul>
        </div>

        {{-- Form side --}}
        <div class="p-8 sm:p-12">
            <h1 class="font-display text-2xl font-extrabold text-paw-800">Giriş yapın</h1>
            <p class="mt-1 text-sm text-slate-500">Hesabınız yok mu? <a href="{{ route('register') }}" class="font-semibold text-paw-600 hover:underline">Hemen oluşturun</a></p>

            <div class="mt-5 rounded-2xl bg-cream-100 px-4 py-3 text-xs text-slate-500">
                <span class="font-semibold text-paw-700">Demo giriş:</span> demo@paticare.com · şifre: password
            </div>

            @if (session('status'))
                <div class="mt-4 rounded-2xl bg-paw-100 px-4 py-3 text-sm font-semibold text-paw-700">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="label" for="email">E-posta</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" class="input" placeholder="ornek@mail.com" required autofocus>
                    @error('email')<p class="mt-1 text-sm text-peach-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label" for="password">Şifre</label>
                    <input id="password" name="password" type="password" class="input" placeholder="••••••••" required>
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-500">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-paw-200 text-paw-500 focus:ring-paw-300"> Beni hatırla
                </label>
                <button type="submit" class="btn-primary w-full">Giriş Yap</button>
            </form>
        </div>
    </div>
</section>
@endsection
