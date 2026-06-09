@extends('layouts.app')

@section('title', 'Hesap Oluştur')

@section('content')
<section class="section py-16">
    <div class="mx-auto grid max-w-5xl overflow-hidden rounded-[2.5rem] bg-white shadow-2xl shadow-paw-900/10 lg:grid-cols-2">
        <div class="relative hidden bg-peach-500 p-10 text-white lg:flex lg:flex-col lg:justify-between">
            <div class="absolute -right-10 -top-10 h-48 w-48 rounded-full bg-peach-400/50 blur-2xl"></div>
            <div class="relative">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-white/20 text-2xl">🐶</span>
                <h2 class="mt-6 font-display text-3xl font-extrabold leading-tight">Aramıza katılın!</h2>
                <p class="mt-3 text-white/90">Dostlarınızın sağlık geçmişini tek bir yerde tutun, aşı zamanını asla kaçırmayın.</p>
            </div>
            <p class="relative text-sm text-white/90">Zaten üye misiniz? <a href="{{ route('login') }}" class="font-bold underline">Giriş yapın</a></p>
        </div>

        <div class="p-8 sm:p-12">
            <h1 class="font-display text-2xl font-extrabold text-paw-800">Hesap oluşturun</h1>
            <p class="mt-1 text-sm text-slate-500">Birkaç saniyede ücretsiz hesabınızı oluşturun.</p>

            <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label class="label" for="name">Ad Soyad</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" class="input" placeholder="Adınız Soyadınız" required autofocus>
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
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="label" for="password">Şifre</label>
                        <input id="password" name="password" type="password" class="input" placeholder="En az 6 karakter" required>
                        @error('password')<p class="mt-1 text-sm text-peach-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label" for="password_confirmation">Şifre (tekrar)</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" class="input" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="btn-primary w-full">Hesap Oluştur</button>
            </form>
        </div>
    </div>
</section>
@endsection
