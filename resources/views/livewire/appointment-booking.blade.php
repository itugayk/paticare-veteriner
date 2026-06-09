<div class="mx-auto max-w-4xl">
    @if ($completed)
        {{-- ============ CONFIRMATION ============ --}}
        <div class="card p-8 text-center sm:p-12">
            <div class="mx-auto grid h-20 w-20 place-items-center rounded-full bg-paw-100 text-4xl">🎉</div>
            <h2 class="mt-6 font-display text-3xl font-extrabold text-paw-800">Randevunuz alındı!</h2>
            <p class="mx-auto mt-3 max-w-md text-slate-500">
                Talebiniz <span class="font-bold text-paw-700">#{{ $confirmationId }}</span> numarasıyla oluşturuldu.
                Onay için en kısa sürede sizinle iletişime geçeceğiz.
            </p>

            <div class="mx-auto mt-8 max-w-md space-y-3 rounded-2xl bg-cream-100 p-6 text-left text-sm">
                <div class="flex justify-between"><span class="text-slate-400">Hizmet</span><span class="font-semibold text-paw-800">{{ $this->services->firstWhere('id', $serviceId)?->name }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Hekim</span><span class="font-semibold text-paw-800">{{ $vetId ? $this->vets->firstWhere('id', $vetId)?->name : 'Fark etmez' }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Tarih</span><span class="font-semibold text-paw-800">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }} · {{ $timeSlot }}</span></div>
                <div class="flex justify-between"><span class="text-slate-400">Dost</span><span class="font-semibold text-paw-800">{{ $petName }}</span></div>
            </div>

            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('home') }}" class="btn-ghost">Ana Sayfaya Dön</a>
                @auth
                    <a href="{{ route('owner.dashboard') }}" class="btn-primary">Randevularımı Gör</a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary">Hesap Oluştur & Takip Et</a>
                @endauth
            </div>
        </div>
    @else
        {{-- ============ STEPPER ============ --}}
        @php
            $steps = [1 => 'Hizmet', 2 => 'Hekim', 3 => 'Tarih & Saat', 4 => 'Bilgiler'];
        @endphp
        <div class="mb-8 flex items-center justify-between">
            @foreach ($steps as $i => $label)
                <button type="button" wire:click="goToStep({{ $i }})" class="flex flex-1 flex-col items-center gap-2 {{ $i < $step ? 'cursor-pointer' : 'cursor-default' }}">
                    <span class="grid h-11 w-11 place-items-center rounded-full font-display text-base font-bold transition
                        {{ $i === $step ? 'bg-paw-500 text-white shadow-lg shadow-paw-500/30' : ($i < $step ? 'bg-paw-100 text-paw-700' : 'bg-white text-slate-300 ring-1 ring-paw-100') }}">
                        @if ($i < $step) <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg> @else {{ $i }} @endif
                    </span>
                    <span class="hidden text-xs font-semibold sm:block {{ $i <= $step ? 'text-paw-700' : 'text-slate-300' }}">{{ $label }}</span>
                </button>
                @if (! $loop->last)
                    <span class="mx-1 h-0.5 flex-1 rounded {{ $i < $step ? 'bg-paw-300' : 'bg-paw-100' }}"></span>
                @endif
            @endforeach
        </div>

        <div class="card p-6 sm:p-8">
            {{-- STEP 1 — Service --}}
            @if ($step === 1)
                <h2 class="font-display text-2xl font-extrabold text-paw-800">Hangi hizmet için geliyorsunuz?</h2>
                <p class="mt-1 text-sm text-slate-500">Dostunuz için uygun hizmeti seçin.</p>
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($this->services as $service)
                        <button type="button" wire:click="selectService({{ $service->id }})"
                            class="group flex items-start gap-4 rounded-3xl border-2 p-5 text-left transition
                            {{ $serviceId === $service->id ? 'border-paw-400 bg-paw-50' : 'border-paw-100 hover:border-paw-300 hover:bg-cream-100' }}">
                            <span class="grid h-12 w-12 shrink-0 place-items-center rounded-2xl {{ $service->color === 'peach' ? 'bg-peach-100 text-peach-600' : 'bg-paw-100 text-paw-600' }}">
                                <x-service-icon :name="$service->icon" class="h-6 w-6" />
                            </span>
                            <span>
                                <span class="block font-display font-bold text-paw-800">{{ $service->name }}</span>
                                <span class="mt-0.5 block text-xs text-slate-400">{{ $service->excerpt }}</span>
                            </span>
                        </button>
                    @endforeach
                </div>
                @error('serviceId')<p class="mt-3 text-sm text-peach-600">{{ $message }}</p>@enderror
            @endif

            {{-- STEP 2 — Vet --}}
            @if ($step === 2)
                <h2 class="font-display text-2xl font-extrabold text-paw-800">Bir hekim tercihiniz var mı?</h2>
                <p class="mt-1 text-sm text-slate-500">Dilerseniz size en uygun hekimi biz atayalım.</p>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <button type="button" wire:click="selectVet(null)"
                        class="flex items-center gap-4 rounded-3xl border-2 p-5 text-left transition {{ is_null($vetId) ? 'border-peach-300 bg-peach-50' : 'border-paw-100 hover:border-paw-300' }}">
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-peach-100 text-2xl">🐾</span>
                        <span><span class="block font-display font-bold text-paw-800">Fark etmez</span><span class="text-xs text-slate-400">Uygun ilk hekim</span></span>
                    </button>
                    @foreach ($this->vets as $vet)
                        <button type="button" wire:click="selectVet({{ $vet->id }})"
                            class="flex items-center gap-4 rounded-3xl border-2 p-5 text-left transition {{ $vetId === $vet->id ? 'border-paw-400 bg-paw-50' : 'border-paw-100 hover:border-paw-300' }}">
                            <img src="{{ media_url($vet->photo) }}" alt="" class="h-12 w-12 rounded-2xl object-cover">
                            <span><span class="block font-display font-bold text-paw-800">{{ $vet->name }}</span><span class="text-xs text-slate-400">{{ $vet->specialty }}</span></span>
                        </button>
                    @endforeach
                </div>
                <div class="mt-8 flex justify-between">
                    <button type="button" wire:click="goToStep(1)" class="btn-ghost">Geri</button>
                    <button type="button" wire:click="$set('step', 3)" class="btn-primary">Devam Et</button>
                </div>
            @endif

            {{-- STEP 3 — Date & Time --}}
            @if ($step === 3)
                <h2 class="font-display text-2xl font-extrabold text-paw-800">Tarih ve saat seçin</h2>
                <p class="mt-1 text-sm text-slate-500">Müsait gün ve saatlerden size uygun olanı işaretleyin.</p>

                <div class="mt-6">
                    <label class="label" for="date">Tarih</label>
                    <input id="date" type="date" wire:model.live="date" min="{{ now()->toDateString() }}" max="{{ now()->addMonths(3)->toDateString() }}" class="input max-w-xs">
                    @error('date')<p class="mt-1 text-sm text-peach-600">{{ $message }}</p>@enderror
                </div>

                @if ($date)
                    <div class="mt-6">
                        <p class="label">Müsait saatler</p>
                        @if (count($this->slots) === 0)
                            <p class="rounded-2xl bg-cream-100 px-4 py-3 text-sm text-slate-500">Bu tarihte uygun saat bulunamadı. Lütfen başka bir gün seçin.</p>
                        @else
                            <div class="grid grid-cols-3 gap-2 sm:grid-cols-5">
                                @foreach ($this->slots as $slot)
                                    <button type="button" wire:click="selectSlot('{{ $slot }}')"
                                        class="rounded-2xl border-2 py-2.5 font-display text-sm font-bold transition
                                        {{ $timeSlot === $slot ? 'border-paw-400 bg-paw-500 text-white' : 'border-paw-100 text-paw-700 hover:border-paw-300' }}">
                                        {{ $slot }}
                                    </button>
                                @endforeach
                            </div>
                        @endif
                        @error('timeSlot')<p class="mt-2 text-sm text-peach-600">{{ $message }}</p>@enderror
                    </div>
                @endif

                <div class="mt-8 flex justify-between">
                    <button type="button" wire:click="goToStep(2)" class="btn-ghost">Geri</button>
                    <button type="button" wire:click="nextStep" class="btn-primary">Devam Et</button>
                </div>
            @endif

            {{-- STEP 4 — Details --}}
            @if ($step === 4)
                <h2 class="font-display text-2xl font-extrabold text-paw-800">Son adım — bilgileriniz</h2>
                <p class="mt-1 text-sm text-slate-500">Sizinle iletişim kurabilmemiz için birkaç bilgi.</p>

                @auth
                    @if ($this->myPets->isNotEmpty())
                        <div class="mt-6">
                            <p class="label">Hangi dostunuz için?</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($this->myPets as $pet)
                                    <button type="button" wire:click="selectPet({{ $pet->id }})"
                                        class="inline-flex items-center gap-2 rounded-full border-2 px-4 py-2 text-sm font-semibold transition
                                        {{ $petId === $pet->id ? 'border-paw-400 bg-paw-50 text-paw-700' : 'border-paw-100 text-slate-500 hover:border-paw-300' }}">
                                        <span>{{ $pet->emoji }}</span> {{ $pet->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endauth

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="label">Ad Soyad</label>
                        <input type="text" wire:model="ownerName" class="input" placeholder="Adınız">
                        @error('ownerName')<p class="mt-1 text-sm text-peach-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label">Telefon</label>
                        <input type="text" wire:model="ownerPhone" class="input" placeholder="05xx xxx xx xx">
                        @error('ownerPhone')<p class="mt-1 text-sm text-peach-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label">E-posta <span class="font-normal text-slate-400">(opsiyonel)</span></label>
                        <input type="email" wire:model="ownerEmail" class="input" placeholder="ornek@mail.com">
                        @error('ownerEmail')<p class="mt-1 text-sm text-peach-600">{{ $message }}</p>@enderror
                    </div>
                    <div></div>
                    <div>
                        <label class="label">Dostunuzun adı</label>
                        <input type="text" wire:model="petName" class="input" placeholder="Örn. Boncuk">
                        @error('petName')<p class="mt-1 text-sm text-peach-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="label">Türü</label>
                        <select wire:model="petSpecies" class="input">
                            @foreach (\App\Models\Pet::SPECIES as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="label">Eklemek istedikleriniz <span class="font-normal text-slate-400">(opsiyonel)</span></label>
                        <textarea wire:model="notes" rows="3" class="input" placeholder="Şikayet, belirti veya not..."></textarea>
                    </div>
                </div>

                {{-- Summary --}}
                <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-2 rounded-2xl bg-cream-100 px-5 py-4 text-sm">
                    <span class="font-semibold text-paw-700">{{ $this->services->firstWhere('id', $serviceId)?->name }}</span>
                    <span class="text-slate-400">·</span>
                    <span class="text-slate-500">{{ $vetId ? $this->vets->firstWhere('id', $vetId)?->name : 'Fark etmez' }}</span>
                    <span class="text-slate-400">·</span>
                    <span class="text-slate-500">{{ $date ? \Carbon\Carbon::parse($date)->translatedFormat('d F Y') : '' }} {{ $timeSlot }}</span>
                </div>

                <div class="mt-8 flex justify-between">
                    <button type="button" wire:click="goToStep(3)" class="btn-ghost">Geri</button>
                    <button type="button" wire:click="submit" class="btn-primary" wire:loading.attr="disabled" wire:target="submit">
                        <span wire:loading.remove wire:target="submit">Randevuyu Tamamla 🐾</span>
                        <span wire:loading wire:target="submit">Gönderiliyor...</span>
                    </button>
                </div>
            @endif
        </div>
    @endif
</div>
