<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('species'); // kedi | kopek | kus | kemirgen | diger
            $table->string('breed')->nullable();
            $table->string('gender')->nullable(); // erkek | disi
            $table->date('birth_date')->nullable();
            $table->decimal('weight_kg', 5, 2)->nullable();
            $table->string('color')->nullable();
            $table->string('microchip_no')->nullable();
            $table->boolean('is_neutered')->default(false);
            $table->string('photo')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
