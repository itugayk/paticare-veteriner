<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('pet_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('vet_id')->nullable()->constrained()->nullOnDelete();
            $table->date('date');
            $table->string('time_slot'); // HH:MM
            $table->string('status')->default('pending'); // pending | confirmed | completed | cancelled
            // Guest / contact details (filled even without account)
            $table->string('owner_name');
            $table->string('owner_phone');
            $table->string('owner_email')->nullable();
            $table->string('pet_name')->nullable();
            $table->string('pet_species')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['date', 'vet_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
