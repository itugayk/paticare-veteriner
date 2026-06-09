<footer class="mt-24 bg-paw-800 text-paw-50">
    <div class="section grid gap-10 py-16 md:grid-cols-2 lg:grid-cols-4">
        <div>
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <span class="grid h-11 w-11 place-items-center rounded-2xl bg-paw-500 text-white">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><path d="M12 13.5c2.2 0 4.5 1.7 4.5 3.9 0 1.4-1.1 2.1-2.4 2.1-.9 0-1.6-.4-2.1-.4s-1.2.4-2.1.4c-1.3 0-2.4-.7-2.4-2.1 0-2.2 2.3-3.9 4.5-3.9Zm-5-1.2c1 0 1.6 1.1 1.4 2.3-.2 1.2-1.1 2-2.1 1.8-1-.2-1.6-1.3-1.4-2.5.2-1.1 1.1-1.8 2.1-1.6Zm10 0c1-.2 1.9.5 2.1 1.6.2 1.2-.4 2.3-1.4 2.5-1 .2-1.9-.6-2.1-1.8-.2-1.2.4-2.3 1.4-2.3ZM9 6.2c1 0 1.7 1.1 1.5 2.4-.2 1.3-1.1 2.1-2.1 2-1-.2-1.7-1.3-1.5-2.6C7.1 6.8 8 6 9 6.2Zm6 0c1-.2 1.9.6 2.1 1.8.2 1.3-.5 2.4-1.5 2.6-1 .1-1.9-.7-2.1-2-.2-1.3.5-2.4 1.5-2.4Z"/></svg>
                </span>
                <span class="font-display text-xl font-extrabold text-white">PatiCare</span>
            </a>
            <p class="mt-4 max-w-xs text-sm leading-relaxed text-paw-100/80">Dostlarımızın sağlığı için sıcak, sevecen ve güvenilir veteriner bakımı. Çünkü onlar ailemizin bir parçası. 🐾</p>
        </div>

        <div>
            <h4 class="font-display text-base font-bold text-white">Hızlı Bağlantılar</h4>
            <ul class="mt-4 space-y-2.5 text-sm text-paw-100/80">
                <li><a class="transition hover:text-white" href="{{ route('services') }}">Hizmetlerimiz</a></li>
                <li><a class="transition hover:text-white" href="{{ route('vets') }}">Veteriner Hekimler</a></li>
                <li><a class="transition hover:text-white" href="{{ route('gallery') }}">Galeri</a></li>
                <li><a class="transition hover:text-white" href="{{ route('blog.index') }}">Bakım Rehberi</a></li>
                <li><a class="transition hover:text-white" href="{{ route('owner.dashboard') }}">Evcil Hayvan Sahibi Girişi</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-display text-base font-bold text-white">İletişim</h4>
            <ul class="mt-4 space-y-2.5 text-sm text-paw-100/80">
                <li class="flex gap-2"><span>📍</span> Bağdat Caddesi No:128, Kadıköy / İstanbul</li>
                <li class="flex gap-2"><span>📞</span> <a class="transition hover:text-white" href="tel:+908500000000">0850 000 00 00</a></li>
                <li class="flex gap-2"><span>✉️</span> <a class="transition hover:text-white" href="mailto:merhaba@paticare.com">merhaba@paticare.com</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-display text-base font-bold text-white">Çalışma Saatleri</h4>
            <ul class="mt-4 space-y-2.5 text-sm text-paw-100/80">
                <li class="flex justify-between gap-4"><span>Pazartesi – Cuma</span> <span class="font-semibold text-white">09:00 – 20:00</span></li>
                <li class="flex justify-between gap-4"><span>Cumartesi – Pazar</span> <span class="font-semibold text-white">10:00 – 18:00</span></li>
                <li class="mt-3 rounded-2xl bg-peach-500/90 px-4 py-3 font-semibold text-white">🚑 Acil servis 7/24 açıktır</li>
            </ul>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="section flex flex-col items-center justify-between gap-3 py-6 text-sm text-paw-100/70 sm:flex-row">
            <p>© {{ date('Y') }} PatiCare Veteriner Kliniği. Tüm hakları saklıdır.</p>
            <p>Sevgiyle tasarlandı 🐾 · <a href="/admin" class="transition hover:text-white">Yönetim</a></p>
        </div>
    </div>
</footer>
