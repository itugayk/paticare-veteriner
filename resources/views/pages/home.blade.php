@extends('layouts.app')

@section('title', 'PatiCare Veteriner Kliniği — Dostlarımıza Sevgiyle Bakıyoruz')

@section('content')

{{-- ===================== HERO ===================== --}}
<section class="relative overflow-hidden">
    <div class="absolute inset-0 -z-10 bg-gradient-to-b from-cream-100 to-cream-50"></div>
    <div class="absolute right-0 top-10 -z-10 h-72 w-72 rounded-full bg-paw-100/70 blur-3xl"></div>
    <div class="absolute -left-20 top-40 -z-10 h-72 w-72 rounded-full bg-peach-100/70 blur-3xl"></div>

    <div class="section grid items-center gap-12 py-14 lg:grid-cols-2 lg:py-20">
        <div>
            <span class="eyebrow">🐾 PatiCare Veteriner Kliniği</span>
            <h1 class="mt-5 text-balance font-display text-4xl font-extrabold leading-[1.05] text-paw-800 sm:text-5xl lg:text-6xl">
                Patili dostlarımıza <span class="text-peach-500">sevgiyle</span> ve güvenle bakıyoruz
            </h1>
            <p class="mt-5 max-w-xl text-lg leading-relaxed text-slate-500">
                Genel muayeneden cerrahiye, aşıdan pet kuaföre… Kedi ve köpeklerinizin sağlığı için sıcak, modern ve 7/24 ulaşılabilir bir klinik.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="{{ route('appointment') }}" class="btn-primary">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0V11.25A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                    Randevu Al
                </a>
                <a href="tel:+908500000000" class="btn-peach">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75A2.25 2.25 0 0 1 6 4.5h1.6a1.5 1.5 0 0 1 1.45 1.1l.74 2.7a1.5 1.5 0 0 1-.4 1.46l-1.1 1.1a12 12 0 0 0 5.6 5.6l1.1-1.1a1.5 1.5 0 0 1 1.46-.4l2.7.74a1.5 1.5 0 0 1 1.1 1.45V19.5a2.25 2.25 0 0 1-2.25 2.25C9.7 21.75 2.25 14.3 2.25 5.25"/></svg>
                    Acil Hat: 0850 000 00 00
                </a>
            </div>

            <div class="mt-10 flex flex-wrap items-center gap-x-8 gap-y-4">
                <div class="flex -space-x-3">
                    @foreach (['1574158622682-e40e69881006','1552053831-71594a27632d','1543466835-00a7907e9de1','1518791841217-8f162f1e1131'] as $id)
                        <img class="h-11 w-11 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-{{ $id }}?auto=format&fit=crop&w=100&q=60" alt="">
                    @endforeach
                </div>
                <div>
                    <div class="flex items-center gap-1 text-peach-400">
                        @for ($i = 0; $i < 5; $i++)<svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11.48 3.5a.56.56 0 0 1 1.04 0l2.13 4.32 4.77.7a.56.56 0 0 1 .31.95l-3.45 3.36.81 4.75a.56.56 0 0 1-.81.59L12 16.3l-4.27 2.24a.56.56 0 0 1-.81-.59l.82-4.75-3.46-3.36a.56.56 0 0 1 .31-.95l4.77-.7Z"/></svg>@endfor
                    </div>
                    <p class="text-sm font-semibold text-slate-500">5.000+ mutlu pati dostu</p>
                </div>
            </div>
        </div>

        <div class="relative">
            <div class="blob overflow-hidden border-8 border-white shadow-2xl shadow-paw-900/10">
                <img src="https://images.unsplash.com/photo-1450778869180-41d0601e046e?auto=format&fit=crop&w=900&q=75" alt="Mutlu bir köpek" class="aspect-square w-full object-cover">
            </div>
            <div class="absolute -left-4 bottom-8 flex items-center gap-3 rounded-3xl bg-white p-4 shadow-xl ring-1 ring-paw-900/5 sm:-left-8">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-peach-100 text-2xl">🚑</span>
                <div>
                    <p class="font-display text-sm font-bold text-paw-800">7/24 Acil Servis</p>
                    <p class="text-xs text-slate-400">Her zaman buradayız</p>
                </div>
            </div>
            <div class="absolute -right-2 top-8 flex items-center gap-3 rounded-3xl bg-white p-4 shadow-xl ring-1 ring-paw-900/5 sm:-right-6">
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-paw-100 text-2xl">💉</span>
                <div>
                    <p class="font-display text-sm font-bold text-paw-800">Aşı Hatırlatma</p>
                    <p class="text-xs text-slate-400">Zamanı kaçırma</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== SERVICES ===================== --}}
<section class="section py-16 sm:py-20">
    <x-section-heading eyebrow="Hizmetlerimiz" title="Dostunuzun ihtiyacı olan her şey tek çatı altında"
        subtitle="Koruyucu hekimlikten ileri cerrahiye, sevimli kuaförden petshop’a kadar geniş bir hizmet yelpazesi." />
    <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($services as $service)
            <x-service-card :service="$service" />
        @endforeach
    </div>
    <div class="mt-10 text-center">
        <a href="{{ route('services') }}" class="btn-ghost">Tüm Hizmetleri Gör</a>
    </div>
</section>

{{-- ===================== WHY US (counters) ===================== --}}
<section class="bg-paw-600 py-16 sm:py-20">
    <div class="section">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div class="text-white">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-1.5 font-display text-sm font-bold uppercase tracking-wide">🐾 Neden PatiCare?</span>
                <h2 class="mt-4 text-balance font-display text-3xl font-extrabold sm:text-4xl">Çünkü onlar sizin için aile, bizim için de öyle</h2>
                <p class="mt-4 max-w-lg text-lg leading-relaxed text-paw-50/90">Deneyimli hekim kadromuz, modern ekipmanlarımız ve şefkatli yaklaşımımızla dostlarınıza en iyi bakımı sunuyoruz.</p>
                <ul class="mt-6 space-y-3">
                    @foreach (['7/24 acil servis ve nöbetçi hekim','Modern görüntüleme ve laboratuvar','Dijital evcil hayvan kartı ve aşı takibi','Stressiz, pati dostu klinik ortamı'] as $feat)
                        <li class="flex items-center gap-3 text-paw-50">
                            <span class="grid h-7 w-7 place-items-center rounded-full bg-white/15"><svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg></span>
                            {{ $feat }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="grid grid-cols-2 gap-5" x-data>
                @php
                    $stats = [
                        ['value' => 12, 'suffix' => '+', 'label' => 'Yıllık deneyim', 'emoji' => '🎓'],
                        ['value' => 5000, 'suffix' => '+', 'label' => 'Mutlu pati dostu', 'emoji' => '🐾'],
                        ['value' => 24, 'suffix' => '/7', 'label' => 'Acil servis', 'emoji' => '🚑'],
                        ['value' => 4, 'suffix' => '', 'label' => 'Uzman hekim', 'emoji' => '👩‍⚕️'],
                    ];
                @endphp
                @foreach ($stats as $stat)
                    <div class="rounded-[var(--radius-card)] bg-white/10 p-6 text-center text-white ring-1 ring-white/15 backdrop-blur"
                         x-data="{ n: 0, target: {{ $stat['value'] }}, done: false }"
                         x-intersect.once="let step = Math.max(1, Math.ceil(target/40)); let t = setInterval(() => { n += step; if (n >= target) { n = target; clearInterval(t) } }, 28)">
                        <div class="text-3xl">{{ $stat['emoji'] }}</div>
                        <div class="mt-2 font-display text-4xl font-extrabold"><span x-text="n.toLocaleString('tr-TR')">0</span>{{ $stat['suffix'] }}</div>
                        <p class="mt-1 text-sm text-paw-50/80">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ===================== VETS ===================== --}}
<section class="section py-16 sm:py-20">
    <x-section-heading eyebrow="Ekibimiz" title="Dostlarınıza gönülden bakan hekimler"
        subtitle="Alanında uzman, hayvansever ve güler yüzlü kadromuzla tanışın." />
    <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($vets as $vet)
            <x-vet-card :vet="$vet" />
        @endforeach
    </div>
</section>

{{-- ===================== GALLERY ===================== --}}
<section class="bg-cream-100 py-16 sm:py-20">
    <div class="section">
        <x-section-heading eyebrow="Galeri" title="Kliniğimizden mutlu kareler" />
        <div class="mt-12 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
            @foreach ($gallery as $i => $img)
                <div class="overflow-hidden rounded-3xl {{ $i % 5 === 0 ? 'col-span-2 row-span-2' : '' }}">
                    <img src="{{ media_url($img->image) }}" alt="{{ $img->title }}" loading="lazy"
                         class="h-full w-full object-cover transition duration-500 hover:scale-105">
                </div>
            @endforeach
        </div>
        <div class="mt-10 text-center">
            <a href="{{ route('gallery') }}" class="btn-ghost">Tüm Galeriyi Gör</a>
        </div>
    </div>
</section>

{{-- ===================== TESTIMONIALS ===================== --}}
<section class="section py-16 sm:py-20">
    <x-section-heading eyebrow="Yorumlar" title="Pati sahipleri ne diyor?" />
    <div class="mt-12 grid gap-6 lg:grid-cols-3">
        @foreach ($testimonials as $t)
            <x-testimonial-card :testimonial="$t" />
        @endforeach
    </div>
</section>

{{-- ===================== BLOG ===================== --}}
<section class="bg-cream-100 py-16 sm:py-20">
    <div class="section">
        <x-section-heading eyebrow="Bakım Rehberi" title="Dostunuz için faydalı yazılar"
            subtitle="Beslenme, sağlık ve bakım hakkında hekimlerimizin önerileri." />
        <div class="mt-12 grid gap-6 md:grid-cols-3">
            @foreach ($posts as $post)
                <x-post-card :post="$post" />
            @endforeach
        </div>
    </div>
</section>

{{-- ===================== CTA ===================== --}}
<section class="section py-16 sm:py-20">
    <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-paw-500 to-paw-700 px-6 py-14 text-center shadow-2xl shadow-paw-900/20 sm:px-12">
        <div class="absolute -right-10 -top-10 h-48 w-48 rounded-full bg-white/10 blur-2xl"></div>
        <div class="absolute -bottom-12 -left-8 h-48 w-48 rounded-full bg-peach-400/30 blur-2xl"></div>
        <h2 class="relative text-balance font-display text-3xl font-extrabold text-white sm:text-4xl">Dostunuz için randevu almaya hazır mısınız?</h2>
        <p class="relative mx-auto mt-4 max-w-xl text-lg text-paw-50/90">Birkaç adımda online randevunuzu oluşturun, gerisini bize bırakın. 🐾</p>
        <div class="relative mt-8 flex flex-wrap justify-center gap-3">
            <a href="{{ route('appointment') }}" class="btn-peach">Hemen Randevu Al</a>
            <a href="{{ route('contact') }}" class="btn-ghost !border-white/40 !bg-white/10 !text-white hover:!bg-white/20">Bize Ulaşın</a>
        </div>
    </div>
</section>

@endsection
