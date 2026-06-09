<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Vaccination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $pets = $user->pets()->withCount('appointments')->with('vaccinations')->get();

        $upcomingVaccinations = Vaccination::query()
            ->whereIn('pet_id', $pets->pluck('id'))
            ->whereNotNull('next_due_at')
            ->orderBy('next_due_at')
            ->with('pet')
            ->get()
            ->filter(fn ($v) => in_array($v->reminder_status, ['overdue', 'due_soon']))
            ->take(6);

        $appointments = $user->appointments()
            ->with(['pet', 'service', 'vet'])
            ->orderByDesc('date')
            ->take(10)
            ->get();

        return view('owner.dashboard', compact('user', 'pets', 'upcomingVaccinations', 'appointments'));
    }

    public function petShow(Pet $pet)
    {
        $this->authorizePet($pet);

        $pet->load(['vaccinations.vet', 'appointments.service', 'appointments.vet']);

        return view('owner.pet-show', compact('pet'));
    }

    public function petCreate()
    {
        return view('owner.pet-form', ['pet' => new Pet()]);
    }

    public function petStore(Request $request)
    {
        $data = $this->validatePet($request);
        $data['user_id'] = Auth::id();

        $pet = Pet::create($data);

        return redirect()->route('owner.pets.show', $pet)
            ->with('status', $pet->name . ' profili oluşturuldu! 🐾');
    }

    public function petEdit(Pet $pet)
    {
        $this->authorizePet($pet);

        return view('owner.pet-form', compact('pet'));
    }

    public function petUpdate(Request $request, Pet $pet)
    {
        $this->authorizePet($pet);

        $pet->update($this->validatePet($request));

        return redirect()->route('owner.pets.show', $pet)
            ->with('status', 'Profil güncellendi.');
    }

    private function validatePet(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'species' => ['required', 'string', 'in:' . implode(',', array_keys(Pet::SPECIES))],
            'breed' => ['nullable', 'string', 'max:80'],
            'gender' => ['nullable', 'in:erkek,disi'],
            'birth_date' => ['nullable', 'date', 'before_or_equal:today'],
            'weight_kg' => ['nullable', 'numeric', 'min:0', 'max:200'],
            'color' => ['nullable', 'string', 'max:60'],
            'is_neutered' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);
    }

    private function authorizePet(Pet $pet): void
    {
        abort_unless($pet->user_id === Auth::id(), 403);
    }
}
