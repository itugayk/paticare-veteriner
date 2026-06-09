<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\DatabaseSeeder::class);
    }

    /** Admin can reach every Filament resource index + dashboard. */
    public function test_admin_panel_pages_render(): void
    {
        $admin = User::where('email', 'admin@paticare.com')->first();
        $this->assertNotNull($admin, 'Admin seed user missing — run db:seed');

        $paths = [
            '/admin',
            '/admin/appointments',
            '/admin/pets',
            '/admin/vaccinations',
            '/admin/users',
            '/admin/services',
            '/admin/vets',
            '/admin/posts',
            '/admin/gallery-images',
            '/admin/testimonials',
        ];

        foreach ($paths as $path) {
            $this->actingAs($admin)->get($path)->assertSuccessful();
        }
    }

    /** A non-admin owner cannot access the admin panel. */
    public function test_owner_cannot_access_admin(): void
    {
        $owner = User::where('email', 'demo@paticare.com')->first();
        $this->actingAs($owner)->get('/admin')->assertForbidden();
    }

    /** Owner dashboard renders with seeded pets. */
    public function test_owner_dashboard_renders(): void
    {
        $owner = User::where('email', 'demo@paticare.com')->first();
        $this->actingAs($owner)->get('/panel')
            ->assertSuccessful()
            ->assertSee('Pamuk')
            ->assertSee('Boncuk');
    }

    /** Livewire booking creates an appointment. */
    public function test_appointment_can_be_booked(): void
    {
        $before = Appointment::count();

        \Livewire\Livewire::test(\App\Livewire\AppointmentBooking::class)
            ->set('serviceId', \App\Models\Service::first()->id)
            ->set('vetId', \App\Models\Vet::first()->id)
            ->set('date', now()->addDays(2)->toDateString())
            ->set('timeSlot', '11:00')
            ->set('ownerName', 'Test Sahibi')
            ->set('ownerPhone', '0555 000 00 00')
            ->set('petName', 'Test Dostu')
            ->set('petSpecies', 'kedi')
            ->call('submit')
            ->assertSet('completed', true);

        $this->assertSame($before + 1, Appointment::count());
    }
}
