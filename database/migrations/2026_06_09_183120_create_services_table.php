<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->default('paw');
            $table->string('color')->default('paw'); // paw | peach
            $table->string('excerpt')->nullable();
            $table->text('description')->nullable();
            $table->string('price_from')->nullable();
            $table->unsignedSmallInteger('duration_minutes')->default(30);
            $table->boolean('is_emergency')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
