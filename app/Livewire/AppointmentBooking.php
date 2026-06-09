<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\Vet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AppointmentBooking extends Component
{
    public int $step = 1;

    public ?int $serviceId = null;
    public ?int $vetId = null;          // null = "fark etmez"
    public ?string $date = null;
    public ?string $timeSlot = null;

    public ?int $petId = null;          // existing pet (logged-in owners)
    public string $petName = '';
    public string $petSpecies = 'kedi';

    public string $ownerName = '';
    public string $ownerPhone = '';
    public string $ownerEmail = '';
    public string $notes = '';

    public bool $completed = false;
    public ?int $confirmationId = null;

    public function mount(): void
    {
        if ($svc = request()->integer('service')) {
            if (Service::where('id', $svc)->where('is_active', true)->exists()) {
                $this->serviceId = $svc;
            }
        }

        if ($user = Auth::user()) {
            $this->ownerName = $user->name;
            $this->ownerPhone = (string) $user->phone;
            $this->ownerEmail = (string) $user->email;
        }
    }

    #[Computed]
    public function services()
    {
        return Service::active()->orderBy('sort_order')->get();
    }

    #[Computed]
    public function vets()
    {
        return Vet::active()->orderBy('sort_order')->get();
    }

    #[Computed]
    public function myPets()
    {
        return Auth::check() ? Auth::user()->pets()->orderBy('name')->get() : collect();
    }

    /** Available 30-min slots for the chosen date/vet, minus already-booked ones. */
    #[Computed]
    public function slots()
    {
        if (! $this->date) {
            return [];
        }

        $day = Carbon::parse($this->date);
        $isWeekend = $day->isWeekend();
        $start = $isWeekend ? 10 : 9;
        $end = $isWeekend ? 18 : 20;

        $all = [];
        for ($h = $start; $h < $end; $h++) {
            foreach (['00', '30'] as $m) {
                $all[] = sprintf('%02d:%s', $h, $m);
            }
        }

        $taken = Appointment::query()
            ->whereDate('date', $this->date)
            ->when($this->vetId, fn ($q) => $q->where('vet_id', $this->vetId))
            ->whereIn('status', ['pending', 'confirmed'])
            ->pluck('time_slot')
            ->all();

        if ($this->vetId) {
            $all = array_values(array_diff($all, $taken));
        }

        if ($day->isToday()) {
            $now = Carbon::now();
            $all = array_values(array_filter($all, fn ($s) => Carbon::parse($this->date . ' ' . $s)->gt($now)));
        }

        return $all;
    }

    public function selectService(int $id): void
    {
        $this->serviceId = $id;
        $this->step = 2;
    }

    public function selectVet(?int $id): void
    {
        $this->vetId = $id ?: null;
        $this->step = 3;
    }

    public function updatedDate(): void
    {
        $this->timeSlot = null;
    }

    public function selectSlot(string $slot): void
    {
        $this->timeSlot = $slot;
    }

    public function goToStep(int $step): void
    {
        if ($step < $this->step) {
            $this->step = $step;
        }
    }

    public function nextStep(): void
    {
        match ($this->step) {
            1 => $this->validate(['serviceId' => 'required|exists:services,id']),
            3 => $this->validate([
                'date' => 'required|date|after_or_equal:today',
                'timeSlot' => 'required',
            ], [], ['date' => 'tarih', 'timeSlot' => 'saat']),
            default => null,
        };

        $this->step = min(4, $this->step + 1);
    }

    public function selectPet(int $id): void
    {
        $pet = $this->myPets->firstWhere('id', $id);
        if ($pet) {
            $this->petId = $pet->id;
            $this->petName = $pet->name;
            $this->petSpecies = $pet->species;
        }
    }

    public function submit(): void
    {
        $this->validate([
            'serviceId' => 'required|exists:services,id',
            'date' => 'required|date|after_or_equal:today',
            'timeSlot' => 'required',
            'ownerName' => 'required|string|max:120',
            'ownerPhone' => 'required|string|max:40',
            'ownerEmail' => 'nullable|email|max:160',
            'petName' => 'required|string|max:80',
            'petSpecies' => 'required|string',
            'notes' => 'nullable|string|max:1000',
        ], [], [
            'ownerName' => 'ad soyad', 'ownerPhone' => 'telefon', 'ownerEmail' => 'e-posta',
            'petName' => 'dost adı', 'petSpecies' => 'tür',
        ]);

        $appointment = Appointment::create([
            'user_id' => Auth::id(),
            'pet_id' => $this->petId,
            'service_id' => $this->serviceId,
            'vet_id' => $this->vetId,
            'date' => $this->date,
            'time_slot' => $this->timeSlot,
            'status' => 'pending',
            'owner_name' => $this->ownerName,
            'owner_phone' => $this->ownerPhone,
            'owner_email' => $this->ownerEmail ?: null,
            'pet_name' => $this->petName,
            'pet_species' => $this->petSpecies,
            'notes' => $this->notes ?: null,
        ]);

        $this->confirmationId = $appointment->id;
        $this->completed = true;
    }

    public function render()
    {
        return view('livewire.appointment-booking');
    }
}
